<?php

namespace App\Http\Controllers;

use App\Models\LaporanBertugas;
use App\Models\Jadual;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

class LaporanPkaController extends Controller
{
    // =========================================================
    // 1. BAHAGIAN PENGURUSAN LAPORAN (PKA)
    // =========================================================

    public function index()
    {
        $query = LaporanBertugas::with(['jadual.bahagian', 'jadual.pegawai']);

        if (auth()->user()->role !== 'superadmin') {
            $query->whereHas('jadual', function ($q) {
                $q->where('user_id', auth()->id())
                  ->orWhere('pegawai_ganti_id', auth()->id());
            });
        }

        $laporans = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('laporan.pka.index', compact('laporans'));
    }

    public function create(Request $request)
    {
        $jadualId = $request->query('jadual_id');
        $jadual = Jadual::with('bahagian')->findOrFail($jadualId);

        return view('pka.laporan.create', compact('jadual'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadual_id' => 'required|exists:jaduals,id',
            'status' => 'required|array',
            'catatan' => 'nullable|array',
            'ulasan' => 'nullable|string',
            'catatan_tambahan' => 'nullable|string',
            'nama_pegawai_terakhir' => 'nullable|string|max:255',
        ]);

        $dataSenaraiSemak = [
            'status' => $request->input('status', []),
            'catatan' => $request->input('catatan', [])
        ];

        $kodLaporan = 'LAP-' . date('Ymd') . '-' . rand(100, 999);

        LaporanBertugas::create([
            'kod_laporan' => $kodLaporan,
            'jadual_id' => $request->jadual_id,
            'senarai_semak' => $dataSenaraiSemak,
            'ulasan' => $request->ulasan,
            'catatan_tambahan' => $request->catatan_tambahan,
            'nama_pegawai_terakhir' => $request->nama_pegawai_terakhir,
            'status_pengesahan' => 'dalam_proses',
        ]);

        return redirect()->route('pka.jadual.index')->with('success', 'Laporan bertugas berjaya dihantar.');
    }

    public function laporanb(Request $request)
    {
        $jadualId = $request->query('jadual_id');

        $jadual = null;
        if ($jadualId) {
            $jadual = Jadual::with('bahagian')->find($jadualId);
        }

        return view('pka.laporan.laporanb', compact('jadual'));
    }

    // =========================================================
    // 2. BAHAGIAN PENGESAHAN & TINDAKAN LAPORAN (PKA)
    // =========================================================

    public function senaraiPengesahan()
    {
        $query = LaporanBertugas::with(['jadual.bahagian', 'jadual.pegawai'])
            ->whereIn('status_pengesahan', ['dalam_proses', 'menunggu_pka']);

        if (auth()->user()->role !== 'superadmin') {
            $query->whereHas('jadual', function ($q) {
                $q->where('user_id', auth()->id())
                  ->orWhere('pegawai_ganti_id', auth()->id());
            });
        }

        $laporans = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('pengesahan.index', compact('laporans'));
    }

    public function sahkanLaporan(Request $request, string $id)
    {
        $request->validate([
            'status_pengesahan' => 'required|in:disahkan,ditolak',
        ]);

        $laporan = LaporanBertugas::findOrFail($id);
        $laporan->update([
            'status_pengesahan' => $request->status_pengesahan,
        ]);

        $mesej = $request->status_pengesahan === 'disahkan'
                 ? 'Laporan telah disahkan.'
                 : 'Laporan telah ditolak.';

        return redirect()->route('pka.pengesahan.index')->with('success', $mesej);
    }

    public function hantarKePPKJ(string $id)
    {
        $laporan = LaporanBertugas::findOrFail($id);

        $laporan->update([
            'status_pengesahan' => 'dihantar_ppkj'
        ]);

        return redirect()->back()->with('success', 'Laporan telah disemak dan dihantar kepada PPKJ.');
    }

    public function selesaikanLaporan(Request $request, string $id)
{
    $request->validate([
        'status_tindakan_pka' => 'required|in:Sudah Bertindak,Belum Bertindak',
    ]);

    $laporan = LaporanBertugas::findOrFail($id);

    // Tentukan status pengesahan berdasarkan pilihan tindakan
    $statusPengesahan = ($request->status_tindakan_pka === 'Sudah Bertindak')
                        ? 'selesai'
                        : 'menunggu_tindakan_user';

    $laporan->update([
        'status_tindakan_pka' => $request->status_tindakan_pka,
        'status_pengesahan'   => $statusPengesahan,
    ]);

    $mesej = ($statusPengesahan === 'selesai')
             ? 'Laporan disahkan dan telah selesai sepenuhnya.'
             : 'Status dikemaskini. Menunggu tindakan dan hantaran semula daripada Pegawai Bertugas.';

    return redirect()->back()->with('success', $mesej);
}
}

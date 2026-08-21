<?php

namespace App\Http\Controllers;

use App\Models\LaporanBertugas;
use App\Models\Jadual;
use App\Models\User;
use App\Notifications\PkaSystemNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanUserController extends Controller
{
    /**
     * Paparkan senarai jadual untuk Pegawai Bertugas
     */
    public function index()
    {
        $userId = Auth::id();

        // Cari laporan di mana jadual terikat dengan User ini (sebagai pegawai bertugas atau pegawai ganti)
        $laporans = LaporanBertugas::with(['jadual.bahagian', 'jadual.pegawai', 'jadual.pegawaiGanti'])
            ->whereHas('jadual', function ($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->orWhere('pegawai_ganti_id', $userId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('laporan.user.index', compact('laporans'));
    }

    public function create(Request $request)
    {
        $jadualId = $request->query('jadual_id');

        // Ambil maklumat jadual yang dipilih
        $jadual = Jadual::with('bahagian')->findOrFail($jadualId);

        return view('user.laporan.create', compact('jadual'));
    }

    public function hantarKePka($id)
    {
        // Cari laporan berdasarkan ID
        $laporan = LaporanBertugas::findOrFail($id);

        // Tukar status supaya PKA boleh mula menyemak
        $laporan->update([
            'status_pengesahan' => 'menunggu_pka'
        ]);

        // Hantar notifikasi kepada semua PKA
        $this->hantarNotifikasiKePka(
            'Laporan Dihantar',
            'Pegawai ' . Auth::user()->name . ' telah menghantar laporan untuk semakan PKA.',
            route('pka.laporan.index')
        );

        return redirect()->back()->with('success', 'Laporan berjaya dihantar kepada Pegawai Keselamatan Aras untuk pengesahan.');
    }

    public function laporanb(Request $request)
    {
        // Ambil ID Jadual dari URL
        $jadualId = $request->query('jadual_id');

        $jadual = null;
        if ($jadualId) {
            // Cari jadual berserta bahagiannya
            $jadual = Jadual::with('bahagian')->find($jadualId);
        }

        // Halakan ke fail borang laporan anda
        return view('laporan.user.laporanuser', compact('jadual'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadual_id' => 'required|exists:jaduals,id',
            'status' => 'required|array',       // Memastikan status wujud dalam bentuk array
            'catatan' => 'nullable|array',      // Catatan adalah pilihan (array)
            'ulasan' => 'nullable|string',
            'catatan_tambahan' => 'nullable|string',
            'nama_pegawai_terakhir' => 'nullable|string|max:255',
        ]);

        $dataSenaraiSemak = [
            'status' => $request->input('status', []),
            'catatan' => $request->input('catatan', [])
        ];

        $kodLaporan = 'LAP-' . date('Ymd') . '-' . rand(100, 999);

        // Simpan ke Pangkalan Data
        $laporan = LaporanBertugas::create([
            'kod_laporan' => $kodLaporan,
            'jadual_id' => $request->jadual_id,
            'senarai_semak' => $dataSenaraiSemak, // Laravel akan auto tukar kepada JSON
            'ulasan' => $request->ulasan,
            'catatan_tambahan' => $request->catatan_tambahan,
            'nama_pegawai_terakhir' => $request->nama_pegawai_terakhir,
            'status_pengesahan' => 'dalam_proses',
        ]);

        // HANTAR NOTIFIKASI KEPADA PKA (Laporan Baharu Dicipta)
        $this->hantarNotifikasiKePka(
    'Laporan Baharu Dicipta',
    'Pegawai ' . Auth::user()->name . ' telah menghantar laporan bertugas baharu.',
    route('pka.laporan.index'),
    $kodLaporan,
    'baharu'
);

        return redirect()->route('user.laporan.index')->with('success', 'Laporan bertugas berjaya dihantar dan sedang menunggu pengesahan.');
    }

    public function edit(string $id)
    {
        $laporan = LaporanBertugas::with('jadual.bahagian')->findOrFail($id);

        return view('laporan.user.edit', compact('laporan'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|array',
            'catatan' => 'nullable|array',
            'ulasan' => 'nullable|string',
            'catatan_tambahan' => 'nullable|string',
            'nama_pegawai_terakhir' => 'nullable|string|max:255',
        ]);

        $laporan = LaporanBertugas::findOrFail($id);

        $dataSenaraiSemak = [
            'status' => $request->input('status', []),
            'catatan' => $request->input('catatan', [])
        ];

        // Kemas kini data dan tukar status semula kepada 'dalam_proses'
        $laporan->update([
            'senarai_semak' => $dataSenaraiSemak,
            'ulasan' => $request->ulasan,
            'catatan_tambahan' => $request->catatan_tambahan,
            'nama_pegawai_terakhir' => $request->nama_pegawai_terakhir,
            'status_pengesahan' => 'dalam_proses',
        ]);

        // HANTAR NOTIFIKASI KEPADA PKA
        $this->hantarNotifikasiKePka(
            'Laporan Dikemas Kini',
            'Pegawai ' . Auth::user()->name . ' telah mengemas kini borang laporan (' . $laporan->kod_laporan . ').',
            route('pka.laporan.index')
        );

        return redirect()->route('user.laporan.index')->with('success', 'Laporan berjaya dikemas kini dan dihantar semula kepada PKA.');
    }

    public function updateUlasan(Request $request, string $id)
    {
        $request->validate([
            'ulasan' => 'required|string',
        ]);

        $laporan = LaporanBertugas::findOrFail($id);

        // Kemas kini ulasan, tukar status tindakan PKA, dan jadikan status pengesahan 'selesai'
        $laporan->update([
            'ulasan' => $request->ulasan,
            'status_tindakan_pka' => 'Sudah Bertindak',
            'status_pengesahan' => 'selesai',
        ]);

        // HANTAR NOTIFIKASI KEPADA PKA BAHAWA USER DAH KEMASKINI & SELESAI
      $this->hantarNotifikasiKePka(
    'Laporan Telah Diselesaikan',
    'Pegawai ' . Auth::user()->name . ' telah melengkapkan ulasan tindakan. Status terkini: SELESAI.',
    route('pka.laporan.index'),
    $laporan->kod_laporan,
    'selesai'
);
        return redirect()->back()->with('success', 'Ulasan berjaya dikemas kini dan laporan telah diselesaikan sepenuhnya.');
    }

    /**
     * Fungsi Helper untuk menghantar notifikasi kepada semua PKA
     */
  private function hantarNotifikasiKePka($tajuk, $mesej, $url = '#', $kodLaporan = '-', $kategori = 'baharu')
    {
        $pkaUsers = User::where('role', 'pegawai_keselamatan_aras')->get();
        $namaUser = Auth::user()->name ?? 'Pegawai Bertugas';

        foreach ($pkaUsers as $pka) {
            $pka->notify(new PkaSystemNotification(
                $tajuk,
                $mesej,
                $url,
                $kodLaporan,
                $namaUser,
                $kategori
            ));
        }
    }
}

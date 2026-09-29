<?php

namespace App\Http\Controllers;

use App\Models\LaporanBertugas;
use App\Models\Jadual;
use App\Models\User;
use App\Notifications\PkaSystemNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LaporanUserController extends Controller
{
    /**
     * Paparkan senarai jadual untuk Pegawai Bertugas
     */
    use AuthorizesRequests;
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


        $jadual = Jadual::with('bahagian')->findOrFail($jadualId);

    $this->authorize('create', [LaporanBertugas::class, $jadual]);

       return view('laporan.user.create', compact('jadual'));
    }

    // public function hantarKePka(string $id)
    // {
    //     // Cari laporan berdasarkan ID
    //     $laporan = LaporanBertugas::findOrFail($id);
    //       $this->authorize('update', $laporan);

    //     // Tukar status supaya PKA boleh mula menyemak
    //     $laporan->update([
    //         'status_pengesahan' => 'dalam_proses'
    //     ]);

    //     // Hantar notifikasi kepada semua PKA
    //     $this->hantarNotifikasiKePka(
    //         'Laporan Dihantar',
    //         'Pegawai ' . Auth::user()->name . ' telah menghantar laporan untuk semakan PKA.',
    //         route('pka.laporan.index')
    //     );

    //     return redirect()->back()->with('success', 'Laporan berjaya dihantar kepada Pegawai Keselamatan Aras untuk pengesahan.');
    // }

    public function laporanb(Request $request)
    {
         $jadualId = $request->query('jadual_id');

    $jadual = null;

    if ($jadualId) {
        $jadual = Jadual::with('bahagian')->findOrFail($jadualId);

        $this->authorize('create', [LaporanBertugas::class, $jadual]);
    }

    return view('laporan.user.laporanuser', compact('jadual'));
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

        $jadual = Jadual::findOrFail($request->jadual_id);

        $this->authorize('create', [LaporanBertugas::class, $jadual]);
        $dataSenaraiSemak = [
            'status' => $request->input('status', []),
            'catatan' => $request->input('catatan', [])
        ];

        $kodLaporan = 'LAP-' . date('Ymd') . '-' . rand(100, 999);


        $laporan = LaporanBertugas::create([
            'kod_laporan' => $kodLaporan,
            'jadual_id' => $request->jadual_id,
            'senarai_semak' => $dataSenaraiSemak,
            'ulasan' => $request->ulasan,
            'catatan_tambahan' => $request->catatan_tambahan,
            'nama_pegawai_terakhir' => $request->nama_pegawai_terakhir,
            'status_pengesahan' => 'dihantar_ppkj',
        ]);


        $this->hantarNotifikasiKePpkj(
                'Laporan Baharu Dicipta',
                'Pegawai ' . Auth::user()->name . ' telah menghantar laporan bertugas baharu.',
                route('ppkj.pengesahan.index'),
                $kodLaporan,
                'baharu',
                $jadual->bahagian_id

            );

        return redirect()->route('user.laporan.index')->with('success', 'Laporan bertugas berjaya dihantar dan sedang menunggu pengesahan.');
    }

    public function edit(string $id)
    {
        $laporan = LaporanBertugas::with('jadual.bahagian')->findOrFail($id);
         $this->authorize('update', $laporan);

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
        $this->authorize('update', $laporan);

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
            'status_pengesahan' => 'dihantar_ppkj',
        ]);

        // HANTAR NOTIFIKASI KEPADA PKA
        $this->hantarNotifikasiKePpkj(
            'Laporan Dikemas Kini',
            'Pegawai ' . Auth::user()->name . ' telah mengemas kini borang laporan (' . $laporan->kod_laporan . ').',
            route('ppkj.pengesahan.sahkan', ['id' => $laporan->id]),
        );

        return redirect()->route('user.laporan.index')->with('success', 'Laporan berjaya dikemas kini dan dihantar semula kepada PKA.');
    }
    public function hantarKePPKJ(string $id)
    {
        $laporan = LaporanBertugas::findOrFail($id);

        $laporan->update([
            'status_pengesahan' => 'dihantar_ppkj'
        ]);

        return redirect()->back()->with('success', 'Laporan telah disemak dan dihantar kepada PPKJ.');
    }





//     public function updateUlasan(Request $request, string $id)
//     {
//         $request->validate([
//             'ulasan' => 'required|string',
//         ]);

//         $laporan = LaporanBertugas::findOrFail($id);
//         $this->authorize('update', $laporan);

//         // Kemas kini ulasan, tukar status tindakan PKA, dan jadikan status pengesahan 'selesai'
//         $laporan->update([
//             'ulasan' => $request->ulasan,
//             'status_tindakan_pka' => 'Sudah Bertindak',
//             'status_pengesahan' => 'selesai',
//         ]);

//         // HANTAR NOTIFIKASI KEPADA PKA BAHAWA USER DAH KEMASKINI & SELESAI
//       $this->hantarNotifikasiKePka(
//     'Laporan Telah Diselesaikan',
//     'Pegawai ' . Auth::user()->name . ' telah melengkapkan ulasan tindakan. Status terkini: SELESAI.',
//     route('pka.laporan.index'),
//     $laporan->kod_laporan,
//     'selesai'
// );
//         return redirect()->back()->with('success', 'Ulasan berjaya dikemas kini dan laporan telah diselesaikan sepenuhnya.');
//     }

    /**
     * Fungsi Helper untuk menghantar notifikasi kepada semua PKA
     */
  private function hantarNotifikasiKePpkj(string $tajuk, string $mesej, $url = '#', $kodLaporan = '-', $kategori = 'baharu',$bahagianId = null)
    {
        $pkkjUsers = User::where('role', 'penolong_pegawai_keselamatan_jabatan')
        ->where('bahagian_id',$bahagianId)->get();
        $namaUser = Auth::user()->name ?? 'Pegawai Bertugas';

        foreach ($pkkjUsers as $pkkj) {
            $pkkj->notify(new PkaSystemNotification(
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

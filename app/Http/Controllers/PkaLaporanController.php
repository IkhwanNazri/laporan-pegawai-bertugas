<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LaporanBertugas;
use Illuminate\Http\Request;

class PkaLaporanController extends Controller
{
    public function __construct()
    {
        // PKA-only controller
        $this->middleware(['auth','role:pegawai_keselamatan_aras']);
    }

    public function senaraiPengesahan()
    {
        // Hanya panggil laporan yang statusnya 'dalam_proses'
        $laporans = LaporanBertugas::with(['jadual.bahagian', 'jadual.pegawai'])
            ->where('status_pengesahan', 'dalam_proses')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

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

        return redirect()->route('pengesahan.index')->with('success', $mesej);
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
        $laporan = LaporanBertugas::findOrFail($id);

        $laporan->update([
            'status_tindakan_pka' => $request->status_tindakan_pka,
            'status_pengesahan' => 'selesai',
        ]);

        return redirect()->back()->with('success', 'Status tindakan berjaya dikemaskini.');
    }
}

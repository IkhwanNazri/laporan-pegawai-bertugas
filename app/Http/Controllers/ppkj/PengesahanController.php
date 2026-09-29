<?php

namespace App\Http\Controllers\ppkj;

use App\Http\Controllers\Controller;
use App\Models\LaporanBertugas;
use Illuminate\Http\Request;

class PengesahanController extends Controller
{

    public function index()
    {
        $bahagianId = auth()->user()->bahagian_id;


        $laporans = LaporanBertugas::with(['jadual.bahagian', 'jadual.pegawai'])

           ->where('status_pengesahan', 'dihantar_ppkj')
           ->whereHas('jadual', function ($query) use ($bahagianId) {
            $query->where('bahagian_id', $bahagianId);
        })
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('ppkj.pengesahan.index', compact('laporans'));
    }


    public function sahkan(Request $request, string $id)
    {
        $request->validate([
            'ulasan_ppkj' => 'required|string'
        ]);

        $laporan = LaporanBertugas::findOrFail($id);


        $laporan->update([
            'ulasan_ppkj' => $request->ulasan_ppkj,
            'status_pengesahan' => 'disahkan',
        ]);

        return redirect()->route('ppkj.pengesahan.index')->with('success', 'Laporan berjaya disahkan oleh PPKJ dan dihantar semula ke PKA.');
    }
}

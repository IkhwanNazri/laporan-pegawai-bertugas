<?php

namespace App\Http\Controllers;

use App\Models\Jadual;
use App\Models\User;
use App\Models\Bahagian;
use Illuminate\Http\Request;

class JadualPkaController extends Controller
{

    public function index()
    {
        $query = Jadual::with(['bahagian', 'pegawai', 'pegawaiGanti']);

        if (auth()->user()->role !== 'superadmin') {
            $query->where(function ($q) {
                $q->where('user_id', auth()->id())
                  ->orWhere('pegawai_ganti_id', auth()->id());
            });
        }

        $jaduals = $query->orderBy('tarikh', 'desc')->paginate(10);

        return view('jadual.pka.index', compact('jaduals'));
    }

       public function create()
    {
        $bahagians = Bahagian::all();

        $pegawais = User::whereIn('role', ['pegawai_bertugas', 'pegawai_keselamatan_aras','penolong_pegawai_keselamatan_jabatan'])->get();

        return view('jadual.pka.create', compact('bahagians', 'pegawais'));
    }

    // 3. Simpan Data Jadual Baru Ke Database
    public function store(Request $request)
    {

    $tarikhInput = $request->tarikh ?? $request->tarikh_mula;


    $request->merge([
        'tarikh' => $tarikhInput,
        'jenis'  => $request->jenis ?? 'harian'
    ]);
        $request->validate([
            'bahagian_id' => 'required|exists:bahagians,id',
            'user_id' => 'required|exists:users,id',
            'tarikh' => 'required|date',
            'aras' => 'required|string',
            'jenis'            => 'required|string',
            'pegawai_ganti_id' => 'nullable|exists:users,id',
            'no_telefon' => 'required|string|max:2',
        ]);

        Jadual::create([
            'bahagian_id' => $request->bahagian_id,
            'user_id' => $request->user_id,
            'tarikh' => $request->tarikh,
            'aras' => $request->aras,
            'pegawai_ganti_id' => $request->pegawai_ganti_id,
            'no_telefon' => $request->no_telefon,
            'jenis'=> $request->jenis ?? 'harian',
        ]);
        // dd($request->all());

        return redirect()->route('pka.jadual.index')->with('success', 'Jadual bertugas berjaya ditambah.');
    }
    public function jadualPka()
{
    $userId = auth()->id();

    $jaduals = Jadual::with(['bahagian', 'pegawaiGanti'])
        ->where('user_id', $userId)
        ->orWhere('pegawai_ganti_id', $userId)
        ->orderBy('tarikh', 'desc')
        ->paginate(10);

    return view('jadual.pka', compact('jaduals'));
}

    public function harian()
    {
        $bahagians = Bahagian::all();
        $pegawais = User::whereIn('role', ['pegawai_bertugas', 'pegawai_keselamatan_aras', 'penolong_pegawai_keselamatan_jabatan'])->get();

        $query = Jadual::with(['bahagian', 'pegawai', 'pegawaiGanti'])
            ->whereDate('tarikh', now()->toDateString());

        if (auth()->user()->role !== 'superadmin') {
            $query->where(function ($q) {
                $q->where('user_id', auth()->id())
                  ->orWhere('pegawai_ganti_id', auth()->id());
            });
        }

        $jaduals = $query->orderBy('tarikh', 'desc')->paginate(10);

        return view('jadual.pka.harian', compact('jaduals', 'bahagians', 'pegawais'));
    }


    public function mingguan()
    {
        $bahagians = Bahagian::all();
        $pegawais = User::whereIn('role', ['pegawai_bertugas', 'pegawai_keselamatan_aras', 'penolong_pegawai_keselamatan_jabatan'])->get();

        $query = Jadual::with(['bahagian', 'pegawai', 'pegawaiGanti'])
            ->whereBetween('tarikh', [now()->startOfWeek(), now()->endOfWeek()]);

        if (auth()->user()->role !== 'superadmin') {
            $query->where(function ($q) {
                $q->where('user_id', auth()->id())
                  ->orWhere('pegawai_ganti_id', auth()->id());
            });
        }

        $jaduals = $query->orderBy('tarikh', 'desc')->paginate(10);

        return view('jadual.pka.mingguan', compact('jaduals', 'bahagians', 'pegawais'));
    }
    public function pilihan()
{
    // Halakan ke fail view pilihan anda
    return view('jadual.pka.pilihan');
}
public function destroy(string $id)
{
    $jadual = Jadual::findOrFail($id);
    $jadual->delete();

    return redirect()->route('pka.jadual.index')->with('success', 'Jadual bertugas berjaya dipadam.');
}
}

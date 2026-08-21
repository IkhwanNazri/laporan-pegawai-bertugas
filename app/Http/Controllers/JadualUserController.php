<?php

namespace App\Http\Controllers;

use App\Models\Jadual;
use App\Models\Bahagian;
use App\Models\User;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadualUserController extends Controller
{
    /**
     * Paparkan senarai jadual untuk Pegawai Bertugas
     */
    public function index()
    {
        // Ambil ID pengguna yang sedang log masuk
        $userId = Auth::id();

        // Hanya paparkan jadual di mana pegawai ini terlibat (sebagai pegawai atau pengganti)
        $jaduals = Jadual::with(['bahagian', 'pegawai', 'pegawaiGanti'])
            ->where('user_id', $userId)
            ->orWhere('pegawai_ganti_id', $userId)
            ->orderBy('tarikh', 'desc')
            ->paginate(10);

        // Halakan ke fail resources/views/user/jadual/index.blade.php
        return view('jadual.user.index', compact('jaduals'));
    }
    //   public function create()
    // {
    //     $bahagians = Bahagian::all();

    //     $pegawais = User::whereIn('role', ['pegawai_bertugas', 'pegawai_keselamatan_aras','penolong_pegawai_keselamatan_jabatan'])->get();

    //     return view('jadual.create', compact('bahagians', 'pegawais'));
    // }
}

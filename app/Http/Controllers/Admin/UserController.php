<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Bahagian;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $users = User::with('bahagian')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.pengguna.index', compact('users'));
    }


    public function create()
    {
        $bahagians = Bahagian::all();
        return view('admin.pengguna.create', compact('bahagians'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'no_ic' => 'required|string|unique:users,no_ic',
            'password' => 'required|string|min:3',
            'role' => 'required|in:superadmin,pegawai_keselamatan_aras,pegawai_bertugas,penolong_pegawai_keselamatan_jabatan',
            'bahagian_id' => 'required|exists:bahagians,id',
        ]);

        User::create([
            'name' => $request->name,
            'no_ic' => $request->no_ic,
            'password' => $request->password,
            'role' => $request->role,
            'bahagian_id' => $request->bahagian_id,
        ]);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna baru berjaya ditambah.');
    }


    public function destroy(string$id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berjaya dipadam.');
    }

}

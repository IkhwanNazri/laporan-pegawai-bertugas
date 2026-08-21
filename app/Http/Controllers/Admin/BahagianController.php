<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bahagian;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BahagianController extends Controller
{

    public function index()
    {
        $bahagians = Bahagian::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.bahagian.index', compact('bahagians'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'kod_bahagian' => 'required|string|unique:bahagians,kod_bahagian|max:50',
            'nama_bahagian' => 'required|string|max:255',
        ]);

        Bahagian::create([
            'kod_bahagian' => strtoupper($request->kod_bahagian),
            'nama_bahagian' => $request->nama_bahagian,
        ]);

        return redirect()->route('admin.bahagian.index')->with('success', 'Bahagian baru berjaya ditambah.');
    }

    public function destroy(string $id)
    {
        $bahagian = Bahagian::findOrFail($id);
        $bahagian->delete();

        return redirect()->route('admin.bahagian.index')->with('success', 'Bahagian berjaya dipadam.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Jadual;
use App\Models\User;
use App\Models\Bahagian;
use Illuminate\Support\Facades\Mail;
use App\Mail\JadualBertugasMail;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JadualPkaController extends Controller
{

    public function index()
    {

        $jaduals = Jadual::with(['bahagian', 'pegawai', 'pegawaiGanti'])
        ->whereMonth('tarikh', now()->month)
        ->whereYear('tarikh', now()->year)
        ->orderBy('tarikh', 'asc')
        ->paginate(10);

    // return view('jadual.pka.index', compact('jaduals'));
     return Inertia::render('PKA/Jadual/Index', [
        'jaduals' => $jaduals,
    ]);
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
            // 'tarikh' => 'required|date',
            'tarikh' => 'required_if:jenis,harian|nullable|date',
            'aras' => 'required|string',
            'jenis'            => 'required|string',
            'pegawai_ganti_id' => 'nullable|exists:users,id',
            'no_telefon' => 'required|string|max:15',
             'tarikh_mula' => 'required_if:jenis,mingguan|nullable|date',
        'tarikh_tamat' => 'required_if:jenis,mingguan|nullable|date|after_or_equal:tarikh_mula',
        ]);
                            $tarikhMula = $request->jenis === 'mingguan'
                    ? $request->tarikh_mula
                    : $request->tarikh;

                $tarikhTamat = $request->jenis === 'mingguan'
                    ? $request->tarikh_tamat
                    : $request->tarikh;

              $pegawaiBertindih = Jadual::with('pegawai')
                    ->where('aras', $request->aras)
                    ->where(function ($query) use ($tarikhMula, $tarikhTamat) {
                        $query->where(function ($q) use ($tarikhMula, $tarikhTamat) {
                            $q->where('jenis', 'mingguan')
                                ->whereDate('tarikh_mula', '<=', $tarikhTamat)
                                ->whereDate('tarikh_tamat', '>=', $tarikhMula);
                        })
                        ->orWhere(function ($q) use ($tarikhMula, $tarikhTamat) {
                            $q->where('jenis', 'harian')
                                ->whereBetween('tarikh', [$tarikhMula, $tarikhTamat]);
                        });
                    })
                    ->first();

                if ($pegawaiBertindih) {
                   return back()
                ->withInput()
                ->with(
                    'error',
                    'Tarikh tersebut telah digunakan untuk Aras ' .
                    $request->aras .
                    ' oleh <strong class="text-white bg-blue-500 px-6 py-1 rounded-full font-semibold gap-3">' .
                    e($pegawaiBertindih->pegawai->name) .
                    '</strong>.'
                );
                }

                $jadual = Jadual::create([
                'bahagian_id' => $request->bahagian_id,
                    'user_id' => $request->user_id,
                    'tarikh' => $request->jenis === 'harian'
                        ? $request->tarikh
                        : $request->tarikh_mula,
                    'tarikh_mula' => $request->jenis === 'mingguan'
                        ? $request->tarikh_mula
                        : null,
                    'tarikh_tamat' => $request->jenis === 'mingguan'
                        ? $request->tarikh_tamat
                        : null,
                    'aras' => $request->aras,
                    'pegawai_ganti_id' => $request->pegawai_ganti_id,
                    'no_telefon' => $request->no_telefon,
                    'jenis' => $request->jenis,
            ]);

            // Hantar email kepada semua PKA
           $pegawai = User::find($request->user_id);

            if ($pegawai && $pegawai->email) {
                Mail::to($pegawai->email)->send(
                    new JadualBertugasMail($jadual)
                );
            }
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

        $jaduals = Jadual::with(['bahagian', 'pegawai', 'pegawaiGanti'])
            ->whereDate('tarikh', now()->toDateString())
            ->orderBy('tarikh', 'desc')
            ->paginate(10);

        return view('jadual.pka.harian', compact('jaduals', 'bahagians', 'pegawais'));
    }


    public function mingguan()
    {
        $bahagians = Bahagian::all();
        $pegawais = User::whereIn('role', ['pegawai_bertugas', 'pegawai_keselamatan_aras', 'penolong_pegawai_keselamatan_jabatan'])->get();

        $jaduals = Jadual::with(['bahagian', 'pegawai', 'pegawaiGanti'])
            ->whereBetween('tarikh', [now()->startOfWeek(), now()->endOfWeek()])
            ->orderBy('tarikh', 'desc')
            ->paginate(10);

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
public function reminder($id)
{
    $jadual = Jadual::with(['pegawai', 'bahagian'])->findOrFail($id);

    if (!$jadual->pegawai || !$jadual->pegawai->email) {
        return redirect()->back()->with('error', 'Pegawai ini tiada alamat emel.');
    }

    Mail::to($jadual->pegawai->email)->send(
        new JadualBertugasMail($jadual)
    );

    return redirect()->back()->with(
        'success',
        'Emel peringatan berjaya dihantar kepada ' . $jadual->pegawai->name . '.'
    );
}
    public function bulkEmail(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return back()->with('error', 'Sila pilih jadual terlebih dahulu.');
        }

        $jaduals = Jadual::with(['pegawai', 'bahagian'])
            ->whereIn('id', $ids)
            ->get();

        $count = 0;

        foreach ($jaduals as $jadual) {

            if ($jadual->pegawai && $jadual->pegawai->email) {

                Mail::to($jadual->pegawai->email)->send(
                    new JadualBertugasMail($jadual)
                );

                $count++;
            }
        }

        return back()->with(
            'success',
            "$count emel peringatan berjaya dihantar."
        );
    }


    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return back()->with('error', 'Sila pilih jadual terlebih dahulu.');
        }

        Jadual::whereIn('id', $ids)->delete();

        return back()->with(
            'success',
            'Jadual yang dipilih berjaya dipadam.'
        );
    }
}

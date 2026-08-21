<?php



namespace App\Http\Controllers;



use App\Models\LaporanBertugas;

use App\Models\Jadual;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;



class LaporanController extends \Illuminate\Routing\Controller

{
public function __construct()
    {
        $this->middleware(['auth','role:pegawai_bertugas']);
    }
    public function index()
    {
        $userId = Auth::id();
        $userRole = Auth::user()->role;
        $laporans = LaporanBertugas::with(['jadual.bahagian', 'jadual.pegawai'])
        ->when($userRole === 'pegawai_bertugas', function ($query) use ($userId) {
                return $query->whereHas('jadual', function ($q) use ($userId) {

                    $q->where('user_id', $userId)->orWhere('pegawai_ganti_id', $userId);

                });

            })

            ->orderBy('created_at', 'desc')

            ->paginate(10);



        return view('laporan.index', compact('laporans'));

    }

    public function create(Request $request)

    {

        $jadualId = $request->query('jadual_id');



        // Ambil maklumat jadual yang dipilih

        $jadual = Jadual::with('bahagian')->findOrFail($jadualId);



        return view('laporan.create', compact('jadual'));

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



        // 4. Simpan ke Pangkalan Data

        LaporanBertugas::create([

            'kod_laporan' => $kodLaporan,

            'jadual_id' => $request->jadual_id,

            'senarai_semak' => $dataSenaraiSemak, // Laravel akan auto tukar kepada JSON

            'ulasan' => $request->ulasan,

            'catatan_tambahan' => $request->catatan_tambahan,

            'nama_pegawai_terakhir' => $request->nama_pegawai_terakhir,
             'status_pengesahan' => 'dalam_proses',

        ]);

        return redirect()->route('laporan.index')->with('success', 'Laporan bertugas berjaya dihantar dan sedang menunggu pengesahan.');

    }
    public function laporanb(Request $request)

    {
        $jadualId = $request->query('jadual_id');

        $jadual = null;

        if ($jadualId) {

            $jadual = Jadual::with('bahagian')->find($jadualId);

        }
        // Hantar $jadual ke view laporanb
    return view('laporan.laporanb', compact('jadual'));

    }

}


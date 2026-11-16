<?php

namespace App\Http\Controllers;

use App\Models\Jadual;
use App\Models\LaporanBertugas;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;

        $data = match ($role) {
            'pegawai_keselamatan_aras' => [
                'card' => $this->card(),
                'events' => $this->events(),
                'mainTask' => $this->mainTask(),
                'semuaJadual' => $this->semuaJadual(),
            ],
            'superadmin' => [
                'card' => $this->card(),
                'events' => $this->events(),
            ],
            'penolong_pegawai_keselamatan_jabatan' => $this->ppkj(),
            default => [
                // Hanya jadual di mana user ini pegawai bertugas atau pengganti
                'jaduals' => Jadual::with(['pegawai', 'bahagian', 'laporan'])
                    ->where(fn ($q) => $q->where('user_id', auth()->id())->orWhere('pegawai_ganti_id', auth()->id()))
                    ->orderBy('tarikh')->get(),
            ],
        };

        return Inertia::render('Dashboard/Index', $data);
    }

    // Kad "Dalam Proses" & "Laporan"
    private function card(): array
    {
        return [
            'jadualDalamProses' => Jadual::with('pegawai')
                ->whereDoesntHave('laporan', fn ($q) => $q->where('status_pengesahan', 'selesai'))
                ->latest('tarikh')->take(2)->get(),
            'laporanDalamProses' => LaporanBertugas::with('jadual.pegawai')
                ->where('status_pengesahan', 'dalam_proses')
                ->latest()->take(2)->get(),
        ];
    }

    // Event untuk FullCalendar
    private function events()
    {
        return Jadual::with(['pegawai', 'bahagian'])->orderBy('tarikh')->get()->map(fn ($j) => [
            'id' => $j->id,
            'title' => $j->pegawai->name ?? 'Tiada Pegawai',
            'start' => $j->tarikh,
            'color' => strtolower($j->jenis ?? '') === 'mingguan' ? '#10b981' : '#3b82f6',
            'extendedProps' => [
                'pegawai' => $j->pegawai->name ?? 'Tiada Pegawai',
                'bahagian' => $j->bahagian->kod_bahagian ?? '-',
                'aras' => $j->aras ?? '-',
                'jenis' => ucfirst($j->jenis ?? 'Harian'),
                'telefon' => $j->no_telefon ?? '-',
            ],
        ])->values();
    }

    // Main Task PKA: jadual + peratus senarai semak yang bertanda '/'
    private function mainTask()
    {
        $jaduals = Jadual::with(['pegawai', 'bahagian', 'laporan'])->orderBy('tarikh')->paginate(5);

        $jaduals->getCollection()->transform(function ($jadual) {
            $status = collect($jadual->laporan?->senarai_semak['status'] ?? [])->flatten();
            $jadual->progress = $status->count()
                ? (int) round($status->filter(fn ($s) => $s === '/')->count() / $status->count() * 100)
                : 0;

            return $jadual;
        });

        return $jaduals;
    }

    private function semuaJadual()
    {
        return Jadual::with('pegawai')->withExists('laporan as ada_laporan')->orderBy('tarikh')->get();
    }

    private function ppkj(): array
    {
        $jaduals = Jadual::with(['pegawai', 'bahagian', 'laporan'])
            ->whereHas('laporan')
            ->latest('updated_at')
            ->get();

        return [
            'recent' => $jaduals->filter(fn ($j) => $j->laporan?->status_pengesahan !== 'selesai')->take(5)->values(),
            'history' => $jaduals->filter(fn ($j) => $j->laporan?->status_pengesahan === 'selesai')->take(5)->values(),
        ];
    }
}

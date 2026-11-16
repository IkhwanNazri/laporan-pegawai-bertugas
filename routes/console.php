<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Jadual;
use App\Notifications\PkaSystemNotification;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


// Peringatan kepada pegawai bertugas hari ini (harian & mingguan) yang belum hantar laporan
Artisan::command('jadual:peringatan', function () {
    $hariIni = now('Asia/Kuala_Lumpur')->toDateString();

    $jaduals = Jadual::with(['pegawai', 'pegawaiGanti'])
        ->whereDoesntHave('laporan')
        ->where(function ($q) use ($hariIni) {
            $q->where(fn ($h) => $h->where('jenis', '!=', 'mingguan')->whereDate('tarikh', $hariIni))
              ->orWhere(fn ($m) => $m->where('jenis', 'mingguan')
                  ->whereDate('tarikh_mula', '<=', $hariIni)
                  ->whereDate('tarikh_tamat', '>=', $hariIni));
        })
        ->get();

    $jumlah = 0;
    foreach ($jaduals as $jadual) {
        foreach (array_filter([$jadual->pegawai, $jadual->pegawaiGanti]) as $pegawai) {
            $pegawai->notify(new PkaSystemNotification(
                'Peringatan Tugasan Hari Ini',
                'Anda bertugas hari ini di Aras ' . $jadual->aras . '. Sila lengkapkan laporan sebelum meninggalkan pejabat.',
                url('/user/jadual'),
                '-',
                $pegawai->name,
                'baharu'
            ));
            $jumlah++;
        }
    }

    $this->info("$jumlah peringatan dihantar.");
})->purpose('Hantar peringatan kepada pegawai bertugas hari ini');

Schedule::command('jadual:peringatan')->dailyAt('16:00')->timezone('Asia/Kuala_Lumpur');

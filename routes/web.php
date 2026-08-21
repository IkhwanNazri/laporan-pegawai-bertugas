<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
// use App\Http\Controllers\JadualController;
use App\Http\Controllers\JadualPkaController;
// use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanUserController;
// use App\Http\Controllers\PkaLaporanController;
use App\Http\Controllers\LaporanPkaController;
use App\Http\Controllers\Admin\BahagianController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\JadualUserController;
use App\Http\Controllers\Ppkj\PengesahanController as PpkjPengesahanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Messages\MailMessage;

// ==========================================
// LALUAN UMUM & AUTH
// ==========================================
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $jadual = \App\Models\Jadual::query()
                ->where(function($query) {
                    $query->where('user_id', auth()->id())
                          ->orWhere('pegawai_ganti_id', auth()->id());
                })
                ->whereDate('tarikh', \Carbon\Carbon::today())
                ->first();

    return view('dashboard', compact('jadual'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ==========================================
// 1. PEGAWAI BERTUGAS (USER)
// ==========================================
Route::middleware(['auth', 'role:pegawai_bertugas'])
    ->prefix('user') // URL akan jadi /user/laporan
    ->name('user.')  // Awalan nama automatik: 'user.'
    ->group(function () {

        Route::get('/laporan/laporanb', [LaporanUserController::class, 'laporanb'])->name('laporan.laporanb');
        Route::get('/jadual', [JadualUserController::class, 'index'])->name('jadual.index');
        Route::patch('/laporan/{id}/hantar-pka', [LaporanUserController::class, 'hantarKePka'])->name('laporan.hantar_pka');

        // DIBETULKAN: Tukar kepada 'laporan.update_ulasan' supaya menjadi 'user.laporan.update_ulasan'
        Route::patch('/laporan/{id}/update-ulasan', [LaporanUserController::class, 'updateUlasan'])->name('laporan.update_ulasan');

        // MESTI LETAK RESOURCE DI BAWAH SEKALI
        Route::resource('/laporan', LaporanUserController::class);
});
        Route::get('/jadual', [JadualUserController::class, 'index'])->name('jadual.index');


// ==========================================
// 2. PEGAWAI KESELAMATAN ARAS (PKA)
// ==========================================
Route::middleware(['auth', 'role:pegawai_keselamatan_aras'])
    ->prefix('pka') // URL akan jadi /pka/jadual
    ->name('pka.')  // Route akan jadi pka.jadual.index
    ->group(function () {

        // Pengurusan Jadual
        // Route::get('/jadual-pka', [JadualPkaController::class, 'jadualPka'])->name('jadual.pka.index');
        Route::get('/jadual', [JadualPkaController::class, 'index'])->name('jadual.index');
        Route::get('/jadual/harian', [JadualPkaController::class, 'harian'])->name('jadual.harian');
        Route::get('/jadual/mingguan', [JadualPkaController::class, 'mingguan'])->name('jadual.mingguan');
         Route::get('/jadual/pilihan', [JadualPkaController::class, 'pilihan'])->name('jadual.pilihan');

        Route::resource('jadual', JadualPkaController::class)->except(['index']);
        Route::post('/notifications/mark-as-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    })->name('notifications.read');

        // view laporan
        Route::get('/laporan', [LaporanPkaController::class, 'index'])->name('laporan.index');
         Route::get('/jadual/pilihan', [JadualPkaController::class, 'pilihan'])->name('jadual.pilihan');


        // Pengesahan Laporan PKA
        Route::get('/pengesahan-laporan', [LaporanPkaController::class, 'senaraiPengesahan'])->name('pengesahan.index');
        Route::put('/pengesahan-laporan/{id}', [LaporanPkaController::class, 'sahkanLaporan'])->name('pengesahan.sahkan');
        Route::patch('/pengesahan-laporan/{id}/selesai', [LaporanPkaController::class, 'selesaikanLaporan'])->name('pengesahan.selesai');

        // Tindakan Laporan PKA
        Route::patch('/laporan/{id}/hantar-ppkj', [LaporanPkaController::class, 'hantarKePPKJ'])->name('laporan.hantar');
        Route::patch('/laporan/{id}/selesai', [LaporanPkaController::class, 'selesaikanLaporan'])->name('laporan.selesai');

});


// ==========================================
// 3. PENOLONG PEGAWAI KESELAMATAN JABATAN (PPKJ)
// ==========================================
Route::middleware(['auth', 'role:penolong_pegawai_keselamatan_jabatan'])
    ->prefix('ppkj') // URL akan jadi /ppkj/pengesahan
    ->name('ppkj.')  // Route akan jadi ppkj.pengesahan.index
    ->group(function () {

        Route::get('/pengesahan', [PpkjPengesahanController::class, 'index'])->name('pengesahan.index');
        Route::post('/pengesahan/{id}', [PpkjPengesahanController::class, 'sahkan'])->name('pengesahan.sahkan');

});


// ==========================================
// 4. SUPERADMIN
// ==========================================
Route::middleware(['auth', 'role:superadmin'])
    ->prefix('admin') // URL akan jadi /admin/pengguna
    ->name('admin.')  // Route akan jadi admin.pengguna.index
    ->group(function () {

        Route::resource('pengguna', UserController::class);
        Route::resource('bahagian', BahagianController::class);

});

Route::get('/pka/email-preview', function () {
    // Tarik semua notifikasi sebenar dari database untuk user yang sedang login
    $senaraiEmail = Auth::user()->notifications;

    return view('pka.email_dashboard', compact('senaraiEmail'));
})->name('emails.preview')->middleware('auth');

// 2. Laluan Iframe (Paparkan kandungan e-mel berdasarkan ID Notifikasi)
Route::get('/pka/email-raw/{id?}', function ($id = null) {
    if ($id) {
        $notification = Auth::user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead(); // Tukar status kepada 'Read'
            $data = $notification->data;

            // Jana e-mel
            $email = (new \Illuminate\Notifications\Messages\MailMessage)
                ->markdown('emails.pka_notification', [
                    'tajuk'      => $data['tajuk'] ?? 'Pemberitahuan Sistem',
                    'mesej'      => $data['mesej'] ?? 'Tiada mesej.',
                    'kodLaporan' => $data['kodLaporan'] ?? '-',
                    'namaUser'   => Auth::user()->name,
                    'kategori'   => $data['kategori'] ?? 'baharu',
                    'url'        => $data['url'] ?? '#'
                ]);

            return $email->render(); // <--- TAMBAH INI (Sangat penting supaya jadi paparan web HTML)
        }
    }

    return "<div style='font-family:sans-serif; text-align:center; padding:50px; color:#6b7280;'>Sila pilih e-mel dari senarai di sebelah kiri untuk membaca kandungan.</div>";
})->name('emails.raw')->middleware('auth');
require __DIR__.'/auth.php';

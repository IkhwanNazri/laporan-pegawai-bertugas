<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Bahagian;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Cipta Senarai Bahagian
        $bpm = Bahagian::create(['kod_bahagian' => 'BPM', 'nama_bahagian' => 'Bahagian Pengurusan Maklumat']);
        $bkp = Bahagian::create(['kod_bahagian' => 'BKP', 'nama_bahagian' => 'Bahagian Khidmat Pengurusan']);
        $bkep = Bahagian::create(['kod_bahagian' => 'BKEP', 'nama_bahagian' => 'Bahagian Keselamatan dan Perlindungan']);
        $dtu = Bahagian::create(['kod_bahagian' => 'DTU', 'nama_bahagian' => 'Dewan Tunku Abdul Rahman']);

        // 2. Cipta Akaun Superadmin (Jangan guna Hash::make jika $casts ['password' => 'hashed'] diaktifkan di Model User)
        User::create([
            'name' => 'Superadmin KPN',
            'no_ic' => '000000000000',
            'password' => 'password123',
            'role' => 'superadmin',
            'bahagian_id' => $bpm->id,
        ]);
        
        // 3. Cipta Akaun Penyelia
        User::create([
            'name' => 'Penyelia BPM',
            'no_ic' => '111111111111',
            'password' => 'password123',
            'role' => 'penyelia',
            'bahagian_id' => $bpm->id,
        ]);

        // 4. Cipta Akaun Pegawai Bertugas
        User::create([
            'name' => 'Pegawai Abu',
            'no_ic' => '222222222222',
            'password' => 'password123',
            'role' => 'pegawai_bertugas',
            'bahagian_id' => $bpm->id,
        ]);
    }
}
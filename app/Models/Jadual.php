<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Jadual extends Model
{
    use HasUuids;

    protected $fillable = [
        'bahagian_id', 'user_id', 'tarikh', 'aras', 'pegawai_ganti_id', 'no_telefon','jenis'
    ];

    public function bahagian()
    {
        return $this->belongsTo(Bahagian::class, 'bahagian_id');
    }

    public function pegawai()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pegawaiGanti()
    {
        return $this->belongsTo(User::class, 'pegawai_ganti_id');
    }

    public function laporan()
    {
        return $this->hasOne(LaporanBertugas::class, 'jadual_id');
    }
}

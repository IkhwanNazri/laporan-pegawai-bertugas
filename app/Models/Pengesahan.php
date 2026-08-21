<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Pengesahan extends Model
{
    use HasUuids;

    protected $fillable = [
        'laporan_id', 'user_tandatangan_id', 'ulasan', 'status'
    ];

    public function laporan()
    {
        return $this->belongsTo(LaporanBertugas::class, 'laporan_id');
    }

    public function pegawaiPengesah()
    {
        return $this->belongsTo(User::class, 'user_tandatangan_id');
    }
}

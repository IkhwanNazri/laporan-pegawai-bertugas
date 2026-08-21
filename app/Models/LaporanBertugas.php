<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class LaporanBertugas extends Model
{
    use HasUuids;


    protected $table = 'laporan_bertugas';

    protected $fillable = [
        'kod_laporan', 'jadual_id', 'ulasan', 'masa_tandatangan','senarai_semak','status_pengesahan','ulasan_ppkj','status_tindakan_pka'
    ];

    protected $casts = [
        'masa_tandatangan' => 'datetime',
          'senarai_semak' => 'array',
    ];

    public function jadual()
    {
        return $this->belongsTo(Jadual::class, 'jadual_id');
    }

    public function senaraiSemak()
    {
        return $this->hasMany(SenaraiSemak::class, 'laporan_id');
    }

    // public function bahagianB()
    // {
    //     return $this->hasOne(LaporanBahagianB::class, 'laporan_id');
    // }

    public function pengesahan()
    {
        return $this->hasOne(Pengesahan::class, 'laporan_id');
    }
}

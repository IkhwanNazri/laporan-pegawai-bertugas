<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\User;

class Bahagian extends Model
{
    use HasUuids;
    protected $table = 'bahagians';
    protected $fillable = ['kod_bahagian', 'nama_bahagian'];

    public function users()
    {
        return $this->hasMany(User::class, 'bahagian_id');
    }

    public function jaduals()
    {
        return $this->hasMany(Jadual::class, 'bahagian_id');
    }
}

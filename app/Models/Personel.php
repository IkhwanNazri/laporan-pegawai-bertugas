<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personel extends Model
{
    protected $connection = 'personel';

    protected $table = 'pegawais';

    protected $guarded = [];
}

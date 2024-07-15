<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rezultat extends Model
{
    use HasFactory;

    protected $fillable = [
        'naziv_sobe',
        'ime_igraca',
        'trenutni_rezultat',
    ];


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soba extends Model
{
    use HasFactory;

    protected $fillable = [
        'kod_sobe',
        'maksimalan_broj_igraca',
        'status',
        'naziv_sobe'
    ];

    public function pitanja()
    {
        return $this->hasMany(Pitanje::class, 'kod_sobe', 'kod_sobe');
    }
    
}

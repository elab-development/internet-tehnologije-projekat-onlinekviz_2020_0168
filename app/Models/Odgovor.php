<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odgovor extends Model
{
    use HasFactory;

    protected $fillable = [
        'pitanje_id',
        'tekst_odgovora',
        'tacan_odgovor'
    ];

    public function pitanje()
    {
        return $this->belongsTo(Pitanje::class);
    }    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pitanje extends Model
{
    use HasFactory;

    protected $fillable = ['tekst_pitanja'];

    public $timestamps = false;

    public function odgovori()
    {
        return $this->hasMany(Odgovor::class);
    }    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'nome',
        'ano',
        'codigo',
        'genero',
        'disponivel'
    ];
}

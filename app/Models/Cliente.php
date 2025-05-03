<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'nome',
        'idade',
        'cpf',
        'cep',
        'rua',
        'numero',
        'cidade',
        'bairro',
        'complemento'
    ];
}
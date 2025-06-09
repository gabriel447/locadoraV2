<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'idade',
        'cpf',
        'data_nascimento',
        'cep',
        'rua',
        'numero',
        'cidade',
        'bairro',
        'complemento'
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locacao extends Model
{
    protected $table = 'locacoes';

    protected $fillable = [
        'nome_cliente',
        'nome_filme',
        'codigo_filme',
        'data_locacao',
        'data_devolucao',
        'valor',
        'multa'
    ];

    protected $casts = [
        'data_locacao' => 'datetime',
        'data_devolucao' => 'datetime',
        'multa' => 'boolean'
    ];
}
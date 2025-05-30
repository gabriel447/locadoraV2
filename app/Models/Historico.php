<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historico extends Model
{
    protected $table = 'historico';
    
    protected $fillable = [
        'nome_cliente',
        'nome_filme',
        'data_locacao',
        'data_devolucao',
        'valor',
        'valor_locacao',
        'valor_total',
        'multa',
        'desconto',
        'observacoes'
    ];

    protected $casts = [
        'data_locacao' => 'date',
        'data_devolucao' => 'date',
        'valor' => 'decimal:2',
        'valor_locacao' => 'decimal:2',
        'valor_total' => 'decimal:2',
        'multa' => 'decimal:2',
        'desconto' => 'decimal:2'
    ];
}
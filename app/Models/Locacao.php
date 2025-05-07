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

    private function getDatasBrasilia()
    {
        return [
            'hoje' => now()->setTimezone('America/Sao_Paulo')->startOfDay(),
            'devolucao' => $this->data_devolucao->setTimezone('America/Sao_Paulo')->startOfDay()
        ];
    }

    protected function getAtrasadoAttribute()
    {
        $datas = $this->getDatasBrasilia();
        return $datas['hoje']->isAfter($datas['devolucao']);
    }

    protected function getDiasAtrasoAttribute()
    {
        if (!$this->atrasado) {
            return 0;
        }
        
        $datas = $this->getDatasBrasilia();
        return $datas['hoje']->diffInDays($datas['devolucao']);
    }
}
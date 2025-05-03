<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;

class ClientesTableSeeder extends Seeder
{
    public function run()
    {
        $clientes = [
            [
                'nome' => 'João Silva',
                'idade' => 30,
                'cpf' => '123.456.789-00',
                'cep' => '01001-000',
                'rua' => 'Avenida Paulista',
                'numero' => '1000',
                'cidade' => 'São Paulo',
                'bairro' => 'Bela Vista',
                'complemento' => 'Apto 101'
            ],
            [
                'nome' => 'Maria Oliveira',
                'idade' => 25,
                'cpf' => '987.654.321-00',
                'cep' => '22021-001',
                'rua' => 'Avenida Atlântica',
                'numero' => '500',
                'cidade' => 'Rio de Janeiro',
                'bairro' => 'Copacabana',
                'complemento' => 'Bloco B'
            ],
            [
                'nome' => 'Pedro Santos',
                'idade' => 40,
                'cpf' => '456.789.123-00',
                'cep' => '30130-110',
                'rua' => 'Rua da Bahia',
                'numero' => '1500',
                'cidade' => 'Belo Horizonte',
                'bairro' => 'Centro',
                'complemento' => null
            ]
        ];

        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }
    }
}
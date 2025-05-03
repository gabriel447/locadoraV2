<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;

class MoviesTableSeeder extends Seeder
{
    public function run()
    {
        $movies = [
            [
                'nome' => 'Matrix',
                'ano' => 1999,
                'codigo' => 12345,
                'genero' => 'Ficção Científica',
                'disponivel' => true
            ],
            [
                'nome' => 'O Senhor dos Anéis',
                'ano' => 2001,
                'codigo' => 23456,
                'genero' => 'Aventura',
                'disponivel' => true
            ],
            [
                'nome' => 'Vingadores: Ultimato',
                'ano' => 2019,
                'codigo' => 34567,
                'genero' => 'Ação',
                'disponivel' => true
            ]
        ];

        foreach ($movies as $movie) {
            Movie::create($movie);
        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class MoviesTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('pt_BR');
        
        // Lista de filmes populares com seus respectivos anos e gêneros
        $filmes = [
            ['nome' => 'O Poderoso Chefão', 'ano' => 1972, 'genero' => 'Drama'],
            ['nome' => 'Pulp Fiction', 'ano' => 1994, 'genero' => 'Crime'],
            ['nome' => 'O Senhor dos Anéis: A Sociedade do Anel', 'ano' => 2001, 'genero' => 'Fantasia'],
            ['nome' => 'Cidade de Deus', 'ano' => 2002, 'genero' => 'Drama'],
            ['nome' => 'Matrix', 'ano' => 1999, 'genero' => 'Ficção Científica'],
            ['nome' => 'Tropa de Elite', 'ano' => 2007, 'genero' => 'Ação'],
            ['nome' => 'Central do Brasil', 'ano' => 1998, 'genero' => 'Drama'],
            ['nome' => 'O Auto da Compadecida', 'ano' => 2000, 'genero' => 'Comédia'],
            ['nome' => 'Vingadores: Ultimato', 'ano' => 2019, 'genero' => 'Ação'],
            ['nome' => 'Interestelar', 'ano' => 2014, 'genero' => 'Ficção Científica'],
            ['nome' => 'Parasita', 'ano' => 2019, 'genero' => 'Drama'],
            ['nome' => 'Coringa', 'ano' => 2019, 'genero' => 'Drama'],
            ['nome' => 'Pantera Negra', 'ano' => 2018, 'genero' => 'Ação'],
            ['nome' => 'La La Land', 'ano' => 2016, 'genero' => 'Musical'],
            ['nome' => 'Clube da Luta', 'ano' => 1999, 'genero' => 'Drama']
        ];
        
        foreach ($filmes as $filme) {
            DB::table('movies')->insert([
                'nome' => $filme['nome'],
                'ano' => $filme['ano'],
                'codigo' => $faker->unique()->numerify('#####'),
                'genero' => $filme['genero'],
                'disponivel' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
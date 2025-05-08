<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class MoviesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('pt_BR');
        
        // Lista de gêneros de filmes
        $generos = [
            'Ação', 'Aventura', 'Comédia', 'Drama', 'Ficção Científica',
            'Terror', 'Romance', 'Animação', 'Documentário', 'Suspense',
            'Fantasia', 'Musical', 'Biografia', 'Histórico', 'Policial'
        ];
        
        // Lista de filmes reais com seus respectivos anos e gêneros
        $filmes = [
            ['nome' => 'O Poderoso Chefão', 'ano' => 1972, 'genero' => 'Drama'],
            ['nome' => 'Pulp Fiction: Tempo de Violência', 'ano' => 1994, 'genero' => 'Drama'],
            ['nome' => 'O Senhor dos Anéis: A Sociedade do Anel', 'ano' => 2001, 'genero' => 'Aventura'],
            ['nome' => 'O Senhor dos Anéis: As Duas Torres', 'ano' => 2002, 'genero' => 'Aventura'],
            ['nome' => 'O Senhor dos Anéis: O Retorno do Rei', 'ano' => 2003, 'genero' => 'Aventura'],
            ['nome' => 'Matrix', 'ano' => 1999, 'genero' => 'Ficção Científica'],
            ['nome' => 'Matrix Reloaded', 'ano' => 2003, 'genero' => 'Ficção Científica'],
            ['nome' => 'Matrix Revolutions', 'ano' => 2003, 'genero' => 'Ficção Científica'],
            ['nome' => 'Interestelar', 'ano' => 2014, 'genero' => 'Ficção Científica'],
            ['nome' => 'Cidade de Deus', 'ano' => 2002, 'genero' => 'Drama'],
            ['nome' => 'Vingadores', 'ano' => 2012, 'genero' => 'Ação'],
            ['nome' => 'Vingadores: Era de Ultron', 'ano' => 2015, 'genero' => 'Ação'],
            ['nome' => 'Vingadores: Guerra Infinita', 'ano' => 2018, 'genero' => 'Ação'],
            ['nome' => 'Vingadores: Ultimato', 'ano' => 2019, 'genero' => 'Ação'],
            ['nome' => 'Star Wars: Episódio IV - Uma Nova Esperança', 'ano' => 1977, 'genero' => 'Ficção Científica'],
            ['nome' => 'Star Wars: Episódio V - O Império Contra-Ataca', 'ano' => 1980, 'genero' => 'Ficção Científica'],
            ['nome' => 'Star Wars: Episódio VI - O Retorno de Jedi', 'ano' => 1983, 'genero' => 'Ficção Científica'],
            ['nome' => 'Harry Potter e a Pedra Filosofal', 'ano' => 2001, 'genero' => 'Fantasia'],
            ['nome' => 'Harry Potter e a Câmara Secreta', 'ano' => 2002, 'genero' => 'Fantasia'],
            ['nome' => 'Harry Potter e o Prisioneiro de Azkaban', 'ano' => 2004, 'genero' => 'Fantasia'],
            ['nome' => 'Harry Potter e o Cálice de Fogo', 'ano' => 2005, 'genero' => 'Fantasia'],
            ['nome' => 'Harry Potter e a Ordem da Fênix', 'ano' => 2007, 'genero' => 'Fantasia'],
            ['nome' => 'Harry Potter e o Enigma do Príncipe', 'ano' => 2009, 'genero' => 'Fantasia'],
            ['nome' => 'Harry Potter e as Relíquias da Morte - Parte 1', 'ano' => 2010, 'genero' => 'Fantasia'],
            ['nome' => 'Harry Potter e as Relíquias da Morte - Parte 2', 'ano' => 2011, 'genero' => 'Fantasia'],
            ['nome' => 'Jurassic Park: O Parque dos Dinossauros', 'ano' => 1993, 'genero' => 'Aventura'],
            ['nome' => 'O Mundo Perdido: Jurassic Park', 'ano' => 1997, 'genero' => 'Aventura'],
            ['nome' => 'Jurassic Park III', 'ano' => 2001, 'genero' => 'Aventura'],
            ['nome' => 'Jurassic World: O Mundo dos Dinossauros', 'ano' => 2015, 'genero' => 'Aventura'],
            ['nome' => 'Titanic', 'ano' => 1997, 'genero' => 'Romance'],
            ['nome' => 'Avatar', 'ano' => 2009, 'genero' => 'Ficção Científica'],
            ['nome' => 'O Rei Leão', 'ano' => 1994, 'genero' => 'Animação'],
            ['nome' => 'O Rei Leão (Live Action)', 'ano' => 2019, 'genero' => 'Aventura'],
            ['nome' => 'Forrest Gump: O Contador de Histórias', 'ano' => 1994, 'genero' => 'Drama'],
            ['nome' => 'Gladiador', 'ano' => 2000, 'genero' => 'Ação'],
            ['nome' => 'Coringa', 'ano' => 2019, 'genero' => 'Drama'],
            ['nome' => 'Pantera Negra', 'ano' => 2018, 'genero' => 'Ação'],
            ['nome' => 'Toy Story', 'ano' => 1995, 'genero' => 'Animação'],
            ['nome' => 'Toy Story 2', 'ano' => 1999, 'genero' => 'Animação'],
            ['nome' => 'Toy Story 3', 'ano' => 2010, 'genero' => 'Animação'],
            ['nome' => 'Toy Story 4', 'ano' => 2019, 'genero' => 'Animação'],
            ['nome' => 'Os Incríveis', 'ano' => 2004, 'genero' => 'Animação'],
            ['nome' => 'Os Incríveis 2', 'ano' => 2018, 'genero' => 'Animação'],
            ['nome' => 'Frozen: Uma Aventura Congelante', 'ano' => 2013, 'genero' => 'Animação'],
            ['nome' => 'Frozen 2', 'ano' => 2019, 'genero' => 'Animação'],
            ['nome' => 'Tropa de Elite', 'ano' => 2007, 'genero' => 'Ação'],
            ['nome' => 'Tropa de Elite 2: O Inimigo Agora é Outro', 'ano' => 2010, 'genero' => 'Ação'],
            ['nome' => 'Central do Brasil', 'ano' => 1998, 'genero' => 'Drama'],
            ['nome' => 'Bacurau', 'ano' => 2019, 'genero' => 'Drama'],
            ['nome' => 'Que Horas Ela Volta?', 'ano' => 2015, 'genero' => 'Drama'],
            ['nome' => 'O Auto da Compadecida', 'ano' => 2000, 'genero' => 'Comédia'],
            ['nome' => 'Parasita', 'ano' => 2019, 'genero' => 'Drama'],
            ['nome' => 'Corações de Ferro', 'ano' => 2014, 'genero' => 'Drama'],
            ['nome' => 'A Origem', 'ano' => 2010, 'genero' => 'Ficção Científica'],
            ['nome' => 'O Lobo de Wall Street', 'ano' => 2013, 'genero' => 'Drama'],
            ['nome' => 'Mad Max: Estrada da Fúria', 'ano' => 2015, 'genero' => 'Ação'],
            ['nome' => 'Clube da Luta', 'ano' => 1999, 'genero' => 'Drama'],
            ['nome' => 'O Silêncio dos Inocentes', 'ano' => 1991, 'genero' => 'Suspense'],
            ['nome' => 'Bastardos Inglórios', 'ano' => 2009, 'genero' => 'Drama'],
            ['nome' => 'Django Livre', 'ano' => 2012, 'genero' => 'Faroeste'],
            ['nome' => 'Kill Bill: Volume 1', 'ano' => 2003, 'genero' => 'Ação'],
            ['nome' => 'Kill Bill: Volume 2', 'ano' => 2004, 'genero' => 'Ação'],
            ['nome' => 'Laranja Mecânica', 'ano' => 1971, 'genero' => 'Drama'],
            ['nome' => 'O Iluminado', 'ano' => 1980, 'genero' => 'Terror'],
            ['nome' => 'Psicose', 'ano' => 1960, 'genero' => 'Terror'],
            ['nome' => 'Tubarão', 'ano' => 1975, 'genero' => 'Terror'],
            ['nome' => 'E.T. - O Extraterrestre', 'ano' => 1982, 'genero' => 'Ficção Científica'],
            ['nome' => 'De Volta para o Futuro', 'ano' => 1985, 'genero' => 'Ficção Científica'],
            ['nome' => 'De Volta para o Futuro 2', 'ano' => 1989, 'genero' => 'Ficção Científica'],
            ['nome' => 'De Volta para o Futuro 3', 'ano' => 1990, 'genero' => 'Ficção Científica'],
            ['nome' => 'Indiana Jones e os Caçadores da Arca Perdida', 'ano' => 1981, 'genero' => 'Aventura'],
            ['nome' => 'Indiana Jones e o Templo da Perdição', 'ano' => 1984, 'genero' => 'Aventura'],
            ['nome' => 'Indiana Jones e a Última Cruzada', 'ano' => 1989, 'genero' => 'Aventura'],
            ['nome' => 'Rocky: Um Lutador', 'ano' => 1976, 'genero' => 'Drama'],
            ['nome' => 'Rocky II: A Revanche', 'ano' => 1979, 'genero' => 'Drama'],
            ['nome' => 'Rocky III: O Desafio Supremo', 'ano' => 1982, 'genero' => 'Drama'],
            ['nome' => 'Rocky IV', 'ano' => 1985, 'genero' => 'Drama'],
            ['nome' => 'Rambo: Programado Para Matar', 'ano' => 1982, 'genero' => 'Ação'],
            ['nome' => 'Rambo II: A Missão', 'ano' => 1985, 'genero' => 'Ação'],
            ['nome' => 'Rambo III', 'ano' => 1988, 'genero' => 'Ação'],
            ['nome' => 'Duro de Matar', 'ano' => 1988, 'genero' => 'Ação'],
            ['nome' => 'Duro de Matar 2', 'ano' => 1990, 'genero' => 'Ação'],
            ['nome' => 'Duro de Matar: A Vingança', 'ano' => 1995, 'genero' => 'Ação'],
            ['nome' => 'Missão: Impossível', 'ano' => 1996, 'genero' => 'Ação'],
            ['nome' => 'Missão: Impossível 2', 'ano' => 2000, 'genero' => 'Ação'],
            ['nome' => 'Missão: Impossível 3', 'ano' => 2006, 'genero' => 'Ação'],
            ['nome' => 'Missão: Impossível - Protocolo Fantasma', 'ano' => 2011, 'genero' => 'Ação'],
            ['nome' => 'Missão: Impossível - Nação Secreta', 'ano' => 2015, 'genero' => 'Ação'],
            ['nome' => 'Missão: Impossível - Efeito Fallout', 'ano' => 2018, 'genero' => 'Ação'],
            ['nome' => 'Velozes e Furiosos', 'ano' => 2001, 'genero' => 'Ação'],
            ['nome' => 'Velozes e Furiosos 5: Operação Rio', 'ano' => 2011, 'genero' => 'Ação'],
            ['nome' => 'Velozes e Furiosos 7', 'ano' => 2015, 'genero' => 'Ação'],
            ['nome' => 'Velozes e Furiosos 8', 'ano' => 2017, 'genero' => 'Ação'],
            ['nome' => 'John Wick: De Volta ao Jogo', 'ano' => 2014, 'genero' => 'Ação'],
            ['nome' => 'John Wick: Um Novo Dia Para Matar', 'ano' => 2017, 'genero' => 'Ação'],
            ['nome' => 'John Wick 3: Parabellum', 'ano' => 2019, 'genero' => 'Ação'],
            ['nome' => 'Batman: O Cavaleiro das Trevas', 'ano' => 2008, 'genero' => 'Ação'],
            ['nome' => 'Batman: O Cavaleiro das Trevas Ressurge', 'ano' => 2012, 'genero' => 'Ação'],
            ['nome' => 'Homem-Aranha', 'ano' => 2002, 'genero' => 'Ação'],
            ['nome' => 'Homem-Aranha 2', 'ano' => 2004, 'genero' => 'Ação'],
            ['nome' => 'Homem-Aranha 3', 'ano' => 2007, 'genero' => 'Ação'],
            ['nome' => 'Homem-Aranha: De Volta ao Lar', 'ano' => 2017, 'genero' => 'Ação'],
            ['nome' => 'Homem-Aranha: Longe de Casa', 'ano' => 2019, 'genero' => 'Ação']
        ];
        
        // Gerar 100 filmes
        for ($i = 0; $i < 100; $i++) {
            // Se temos filmes suficientes na lista, usamos eles
            if ($i < count($filmes)) {
                $filme = $filmes[$i];
                $nome = $filme['nome'];
                $ano = $filme['ano'];
                $genero = $filme['genero'];
            } else {
                // Caso contrário, geramos aleatoriamente
                $nome = $faker->randomElement(array_column($filmes, 'nome')) . ' ' . $faker->optional(0.3, '')->randomElement(['(Remake)', 'Edição Especial', 'Versão Estendida']);
                $ano = $faker->numberBetween(1980, 2023);
                $genero = $faker->randomElement($generos);
            }
            
            DB::table('movies')->insert([
                'nome' => $nome,
                'ano' => $ano,
                'codigo' => $faker->unique()->numberBetween(10000, 99999),
                'genero' => $genero,
                'disponivel' => $faker->boolean(80), // 80% de chance de estar disponível
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
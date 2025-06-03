<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ClientesTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('pt_BR');
        
        // Nomes comuns brasileiros para tornar mais realista
        $nomesHomens = [
            'João', 'José', 'Antônio', 'Francisco', 'Carlos', 'Paulo', 'Pedro', 'Lucas', 
            'Luiz', 'Marcos', 'Gabriel', 'Rafael', 'Daniel', 'Marcelo', 'Bruno', 
            'Eduardo', 'Felipe', 'Raimundo', 'Roberto', 'Rodrigo', 'Márcio', 'Ricardo'
        ];
        
        $nomesMulheres = [
            'Maria', 'Ana', 'Francisca', 'Antônia', 'Adriana', 'Juliana', 'Márcia', 
            'Fernanda', 'Patricia', 'Aline', 'Sandra', 'Camila', 'Amanda', 'Bruna', 
            'Jéssica', 'Letícia', 'Júlia', 'Luciana', 'Vanessa', 'Mariana', 'Gabriela'
        ];
        
        $sobrenomes = [
            'Silva', 'Santos', 'Oliveira', 'Souza', 'Rodrigues', 'Ferreira', 'Alves', 
            'Pereira', 'Lima', 'Gomes', 'Costa', 'Ribeiro', 'Martins', 'Carvalho', 
            'Almeida', 'Lopes', 'Soares', 'Fernandes', 'Vieira', 'Barbosa', 'Rocha', 
            'Dias', 'Nascimento', 'Andrade', 'Moreira', 'Nunes', 'Marques', 'Machado'
        ];
        
        // Cidades brasileiras reais
        $cidades = [
            'São Paulo', 'Rio de Janeiro', 'Belo Horizonte', 'Salvador', 'Fortaleza',
            'Brasília', 'Curitiba', 'Recife', 'Porto Alegre', 'Manaus', 'Belém',
            'Goiânia', 'Guarulhos', 'Campinas', 'São Luís', 'São Gonçalo', 'Maceió',
            'Duque de Caxias', 'Natal', 'Teresina', 'São Bernardo do Campo', 'Nova Iguaçu',
            'João Pessoa', 'Santo André', 'Osasco', 'Jaboatão dos Guararapes', 'Ribeirão Preto'
        ];
        
        // Bairros comuns
        $bairros = [
            'Centro', 'Jardim Paulista', 'Moema', 'Copacabana', 'Ipanema', 'Leblon',
            'Botafogo', 'Tijuca', 'Boa Viagem', 'Pituba', 'Barra', 'Grajaú', 'Lapa',
            'Pinheiros', 'Vila Mariana', 'Bela Vista', 'Consolação', 'Savassi',
            'Boa Vista', 'Meireles', 'Aldeota', 'Jardins', 'Brooklin', 'Itaim Bibi'
        ];
        
        // Ruas comuns
        $tiposLogradouro = ['Rua', 'Avenida', 'Alameda', 'Travessa', 'Praça'];
        $nomesRuas = [
            'das Flores', 'dos Andradas', 'Sete de Setembro', 'Quinze de Novembro',
            'Dom Pedro II', 'Getúlio Vargas', 'Juscelino Kubitschek', 'Santos Dumont',
            'Rio Branco', 'Paulista', 'Brasil', 'da República', 'Tiradentes',
            'São João', 'Barão de Mauá', 'Marechal Deodoro', 'Duque de Caxias'
        ];
        
        // Gerar 100 clientes
        for ($i = 0; $i < 100; $i++) {
            // Determinar gênero para nome mais realista
            $genero = $faker->randomElement(['male', 'female']);
            
            if ($genero == 'male') {
                $primeiroNome = $faker->randomElement($nomesHomens);
            } else {
                $primeiroNome = $faker->randomElement($nomesMulheres);
            }
            
            // Criar nome completo com 1 ou 2 sobrenomes
            $sobrenome1 = $faker->randomElement($sobrenomes);
            $sobrenome2 = $faker->boolean(70) ? ' ' . $faker->randomElement($sobrenomes) : '';
            $nome = $primeiroNome . ' ' . $sobrenome1 . $sobrenome2;
            
            DB::table('clientes')->insert([
                'nome' => $nome,
                'email' => $faker->unique()->safeEmail(),
                'telefone' => $faker->numerify('(##) #####-####'),
                'cpf' => $faker->numerify('###.###.###-##'),
                'data_nascimento' => $faker->dateTimeBetween('-80 years', '-18 years')->format('Y-m-d'),
                'idade' => $faker->numberBetween(18, 80),
                'cep' => $faker->numerify('#####-###'),
                'rua' => $faker->randomElement($tiposLogradouro) . ' ' . $faker->randomElement($nomesRuas),
                'numero' => $faker->buildingNumber(),
                'cidade' => $faker->randomElement($cidades),
                'bairro' => $faker->randomElement($bairros),
                'complemento' => $faker->boolean(30) ? $faker->secondaryAddress() : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
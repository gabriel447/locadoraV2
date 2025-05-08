<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ClientesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
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
            
            // Gerar CPF formatado
            $cpf = $faker->numerify('###.###.###-##');
            
            // Gerar CEP formatado por região
            $cep = $faker->randomElement(['0', '1', '2', '3', '4', '5', '6', '7', '8', '9']) . $faker->numerify('#####-###');
            
            // Endereço mais realista
            $tipoLogradouro = $faker->randomElement($tiposLogradouro);
            $nomeRua = $faker->randomElement($nomesRuas);
            $rua = $tipoLogradouro . ' ' . $nomeRua;
            
            // Complementos realistas
            $complementos = [null, 'Apto ' . $faker->numberBetween(1, 1200), 'Casa ' . $faker->numberBetween(1, 100), 
                            'Bloco ' . $faker->randomLetter . ' Apto ' . $faker->numberBetween(1, 1200),
                            'Fundos', 'Sala ' . $faker->numberBetween(1, 500)];
            
            DB::table('clientes')->insert([
                'nome' => $nome,
                'idade' => $faker->numberBetween(18, 80),
                'cpf' => $cpf,
                'cep' => $cep,
                'rua' => $rua,
                'numero' => $faker->numberBetween(1, 9999),
                'bairro' => $faker->randomElement($bairros),
                'cidade' => $faker->randomElement($cidades),
                'complemento' => $faker->boolean(60) ? $faker->randomElement($complementos) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
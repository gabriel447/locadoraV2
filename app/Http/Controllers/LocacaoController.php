<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Locacao;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Cliente;

class LocacaoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $movies = Movie::orderBy('id', 'asc')->get();
        $clientes = Cliente::orderBy('nome', 'asc')->get();
        return view('locacoes.index', compact('movies', 'clientes'));
    }

    public function store(Request $request)
    {
        try {
            $movie = Movie::where('id', $request->movie_id)->first();
            $cliente = Cliente::find($request->cliente_id);
            
            if (!$movie) {
                return redirect()->back()->with('error', 'Filme não encontrado.');
            }

            if (!$cliente) {
                return redirect()->back()->with('error', 'Cliente não encontrado.');
            }

            if (!$movie->disponivel) {
                return redirect()->back()->with('error', 'Este filme não está disponível para locação.');
            }

            $dataLocacao = Carbon::now();
            $dataDevolucao = Carbon::parse($request->data_devolucao);

            // Verifica se a data de devolução é hoje
            if ($dataDevolucao->isToday()) {
                return redirect()->back()->with('error', 'A data de devolução não pode ser hoje.');
            }

            $diasLocados = $dataLocacao->diffInDays($dataDevolucao) + 1;
            $valorLocacao = $diasLocados * 5;

            // Criar a locação
            $locacao = new Locacao();
            $locacao->nome_cliente = $cliente->nome;
            $locacao->nome_filme = $movie->nome;
            $locacao->codigo_filme = $movie->codigo;
            $locacao->data_locacao = $dataLocacao;
            $locacao->data_devolucao = $dataDevolucao;
            $locacao->valor = $valorLocacao;
            $locacao->multa = false;
            $locacao->save();

            // Atualizar disponibilidade do filme
            $movie->disponivel = false;
            $movie->save();

            return redirect()->back()->with('success', 'Filme locado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao realizar a locação: ' . $e->getMessage());
        }
    }

    public function devolucoes()
    {
        // Alterado para mostrar apenas locações não devolvidas, ordenadas por ID
        $locacoes = Locacao::where('devolvido', false)
                          ->orderBy('id', 'asc')
                          ->get();
        
        // Calcular valores e status para cada locação
        foreach ($locacoes as $locacao) {
            $hoje = Carbon::now();
            $dataDevolucao = Carbon::parse($locacao->data_devolucao);
            
            // Verificar se está atrasado
            $locacao->atrasado = $hoje->gt($dataDevolucao);
            
            // Calcular dias de locação originais
            $diasOriginais = Carbon::parse($locacao->data_locacao)->diffInDays($dataDevolucao) + 1;
            $valorOriginal = $diasOriginais * 5;
            
            // Se estiver atrasado, calcular multa
            if ($locacao->atrasado) {
                // Calcular dias totais de atraso (incluindo fins de semana)
                $diasAtrasoTotal = $hoje->diffInDays($dataDevolucao);
                
                // Calcular dias úteis de atraso (excluindo fins de semana)
                $diasAtrasoUteis = 0;
                $dataAtual = $dataDevolucao->copy()->addDay();
                
                while ($dataAtual->lte($hoje)) {
                    if (!$dataAtual->isWeekend()) {
                        $diasAtrasoUteis++;
                    }
                    $dataAtual->addDay();
                }
                
                $valorMulta = $diasAtrasoUteis * 2.50;
                $diasTotais = Carbon::parse($locacao->data_locacao)->diffInDays($hoje) + 1;
                $valorTotal = $diasTotais * 5 + $valorMulta;
                
                // Atualizar com o número correto de dias de atraso
                $locacao->dias_atraso = $diasAtrasoTotal;
                $locacao->dias_atraso_uteis = $diasAtrasoUteis;
                $locacao->valor_multa = $valorMulta;
                $locacao->valor_total = $valorTotal;
            } else {
                $locacao->dias_atraso = 0;
                $locacao->dias_atraso_uteis = 0;
                $locacao->valor_multa = 0;
                $locacao->valor_total = $valorOriginal;
            }
        }
        
        return view('devolucoes.index', compact('locacoes'));
    }

    public function devolver($id)
    {
        try {
            $locacao = Locacao::findOrFail($id);
            $movie = Movie::where('codigo', $locacao->codigo_filme)->first();
    
            if (!$movie) {
                return redirect()->back()->with('error', 'Filme não encontrado.');
            }
    
            // Calcular multa se houver atraso
            $dataDevolucaoEfetiva = Carbon::now();
            $dataDevolucaoPrevista = Carbon::parse($locacao->data_devolucao);
            
            $valorTotal = $locacao->valor; // Valor original
            
            if ($dataDevolucaoEfetiva->gt($dataDevolucaoPrevista)) {
                $diasAtrasoUteis = 0;
                $dataAtual = $dataDevolucaoPrevista->copy()->addDay();
                
                while ($dataAtual->lte($dataDevolucaoEfetiva)) {
                    if (!$dataAtual->isWeekend()) {
                        $diasAtrasoUteis++;
                    }
                    $dataAtual->addDay();
                }
                
                if ($diasAtrasoUteis > 0) {
                    $locacao->multa = true;
                    // Multa é R$ 2,50 por dia útil de atraso
                    $valorMulta = $diasAtrasoUteis * 2.50;
                    $locacao->valor_multa = $valorMulta;
                    
                    // Recalcular o valor total da locação incluindo os dias de atraso
                    $diasTotais = Carbon::parse($locacao->data_locacao)->diffInDays($dataDevolucaoEfetiva) + 1;
                    $valorDiarias = $diasTotais * 5; // R$ 5,00 por dia
                    
                    $valorTotal = $valorDiarias + $valorMulta;
                }
            }
    
            // Atualizar status do filme e da locação
            $movie->disponivel = true;
            $movie->save();
    
            $locacao->devolvido = true;
            $locacao->data_devolucao_efetiva = $dataDevolucaoEfetiva;
            $locacao->save();
    
            $mensagem = 'Filme devolvido com sucesso!';
            if ($locacao->multa) {
                $mensagem .= ' <strong>Valor total:</strong> R$ ' . number_format($valorTotal, 2, ',', '.');
            }
    
            return redirect()->route('devolucoes.index')->with('success', $mensagem);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao devolver o filme: ' . $e->getMessage());
        }
    }
}
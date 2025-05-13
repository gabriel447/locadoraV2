<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Locacao;
use App\Models\Historico;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Cliente;
use Illuminate\Support\Facades\Log;

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
        $movie = Movie::findOrFail($request->movie_id);
        $cliente = Cliente::findOrFail($request->cliente_id);
        
        $dataLocacao = Carbon::now();
        $dataDevolucao = Carbon::parse($request->data_devolucao);
        
        // Verifica se a data de devolução é fim de semana
        if ($dataDevolucao->isWeekend()) {
            return redirect()->back()->with('error', 'Não é permitido devolver filmes nos finais de semana.');
        }
        
        // Verifica se a devolução é no mesmo dia
        if ($dataLocacao->isSameDay($dataDevolucao)) {
            return redirect()->back()->with('error', 'Não é permitido devolver o filme no mesmo dia da locação.');
        }
        
        // Inicializa o valor total
        $valorTotal = 0;
        
        // Percorre cada dia do período de locação
        $dataAtual = $dataLocacao->copy()->startOfDay();
        $dataDevolucao = $dataDevolucao->copy()->startOfDay();
        
        while ($dataAtual->lt($dataDevolucao)) {
            if ($dataAtual->isWeekend()) {
                $valorTotal += 2.50;
            } else {
                $valorTotal += 5.00;
            }
            $dataAtual->addDay();
        }
        
        $locacao = new Locacao();
        $locacao->nome_cliente = $cliente->nome;
        $locacao->nome_filme = $movie->nome;
        $locacao->codigo_filme = $movie->codigo;
        $locacao->data_locacao = $dataLocacao;
        $locacao->data_devolucao = $dataDevolucao;
        $locacao->valor = $valorTotal;
        $locacao->save();
        
        $movie->disponivel = false;
        $movie->save();
        
        return redirect()->route('locacoes.index')->with('success', 'Filme locado com sucesso!');
    }

    public function devolucoes()
    {
        $locacoes = Locacao::where('devolvido', false)->get();
        $historico = Historico::orderBy('created_at', 'desc')->get();
        return view('devolucoes.index', compact('locacoes', 'historico'));
    }

    public function confirmarDevolucao(Request $request)
    {
        try {
            $locacao = Locacao::findOrFail($request->locacao_id);
            
            // Atualizar o status do filme para disponível
            $filme = Movie::where('codigo', $locacao->codigo_filme)->first();
            if ($filme) {
                $filme->disponivel = true;
                $filme->save();
            }

            $dataDevolucaoPrevista = Carbon::parse($locacao->data_devolucao);
            $dataDevolucaoReal = Carbon::now();
            $valorOriginal = $locacao->valor;
            $multa = 0;
            $desconto = 0;

            // Calcula multa ou desconto baseado na data de devolução
            if ($dataDevolucaoReal->gt($dataDevolucaoPrevista)) {
                // Calcula multa para atraso (dias extras * 5.00 para dias úteis, 2.50 para fins de semana)
                $dataAtual = $dataDevolucaoPrevista->copy();
                while ($dataAtual->lt($dataDevolucaoReal)) {
                    $multa += $dataAtual->isWeekend() ? 2.50 : 5.00;
                    $dataAtual->addDay();
                }
            } elseif ($dataDevolucaoReal->lt($dataDevolucaoPrevista)) {
                // Calcula desconto baseado nos dias que faltam até a data prevista
                $dataAtual = $dataDevolucaoReal->copy()->addDay(); // Começa a contar a partir do dia seguinte
                while ($dataAtual->lt($dataDevolucaoPrevista)) {
                    $desconto += $dataAtual->isWeekend() ? 2.50 : 5.00;
                    $dataAtual->addDay();
                }
            }

            // Criar registro no histórico com todos os campos necessários
            Historico::create([
                'nome_cliente' => $locacao->nome_cliente,
                'nome_filme' => $locacao->nome_filme,
                'data_locacao' => $locacao->data_locacao,
                'data_devolucao' => $dataDevolucaoReal,
                'valor' => $valorOriginal,
                'multa' => $multa,
                'desconto' => $desconto,
                'observacoes' => $request->observacoes ?? ''
            ]);
    
            // Marcar locação como devolvida
            $locacao->devolvido = true;
            $locacao->save();
    
            $mensagem = 'Devolução realizada com sucesso!';
            if ($multa > 0) {
                $mensagem .= ' Multa por atraso: R$ ' . number_format($multa, 2, ',', '.');
            } elseif ($desconto > 0) {
                $mensagem .= ' Desconto por devolução antecipada: R$ ' . number_format($desconto, 2, ',', '.');
            }
    
            return response()->json(['success' => true, 'message' => $mensagem]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro ao processar devolução: ' . $e->getMessage()], 500);
        }
    }

    public function historico()
    {
        try {
            // Buscar todo o histórico, ordenado pelo mais recente
            $historico = Historico::orderBy('created_at', 'desc')->get();
            return response()->json($historico);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao carregar histórico'], 500);
        }
    }
}
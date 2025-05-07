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
        $locacoes = Locacao::where('devolvido', false)
                      ->orderBy('id', 'asc')
                      ->get();
        
        foreach ($locacoes as $locacao) {
            $hoje = Carbon::now();
            $dataDevolucao = Carbon::parse($locacao->data_devolucao);
            
            $locacao->atrasado = $hoje->gt($dataDevolucao);
            
            if ($locacao->atrasado) {
                // Calcular dias de atraso
                $diasAtraso = 0;
                $dataAtual = $dataDevolucao->copy()->addDay();
                
                while ($dataAtual->lte($hoje)) {
                    $diasAtraso++;
                    $dataAtual->addDay();
                }
                
                $valorMulta = $diasAtraso * 2.50; // Multa fixa de R$ 2,50 por dia
                
                $locacao->dias_atraso = $diasAtraso;
                $locacao->valor_multa = $valorMulta;
                $locacao->valor_total = $locacao->valor + $valorMulta;
            } else {
                $locacao->dias_atraso = 0;
                $locacao->valor_multa = 0;
                $locacao->valor_total = $locacao->valor;
            }
        }
        
        return view('devolucoes.index', compact('locacoes'));
    }

    public function devolver($id)
    {
        $locacao = Locacao::findOrFail($id);
        $movie = Movie::where('codigo', $locacao->codigo_filme)->first();
        $dataDevolucaoEfetiva = Carbon::now();
        $dataDevolucaoPrevista = Carbon::parse($locacao->data_devolucao);
        
        // Se houver atraso
        if ($dataDevolucaoEfetiva->gt($dataDevolucaoPrevista)) {
            $diasAtraso = $dataDevolucaoPrevista->diffInDays($dataDevolucaoEfetiva);
            $valorMulta = $diasAtraso * 2.50; // Multa fixa de R$ 2,50 por dia de atraso
            
            $locacao->multa = true;
            $locacao->valor_multa = $valorMulta;
            $locacao->valor_total = $locacao->valor + $valorMulta;
        }
        
        $locacao->devolvido = true;
        $locacao->data_devolucao_efetiva = $dataDevolucaoEfetiva;
        $locacao->save();
        
        $movie->disponivel = true;
        $movie->save();
        
        return redirect()->route('devolucoes.index')->with('success', 'Filme devolvido com sucesso!');
    }
}
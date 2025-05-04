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

            // Criar a locação
            $locacao = new Locacao();
            $locacao->nome_cliente = $cliente->nome; // Usando o nome do cliente selecionado
            $locacao->nome_filme = $movie->nome;
            $locacao->codigo_filme = $movie->codigo;
            $locacao->data_locacao = Carbon::now();
            $locacao->data_devolucao = $request->data_devolucao;
            $locacao->valor = 10.00; // Você pode ajustar este valor conforme necessário
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
        $locacoes = Locacao::where('multa', false)->get();
        return view('devolucoes.index', compact('locacoes'));
    }
}
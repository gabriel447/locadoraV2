<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MovieController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $movies = Movie::all();
        return view('movies.index', compact('movies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'ano' => 'required|integer|min:1900|max:' . (date('Y')),
            'codigo' => 'required|integer|unique:movies,codigo',
            'disponivel' => 'nullable|boolean',
        ]);
        
        $validated['disponivel'] = $request->has('disponivel') ? 1 : 0;

        try {
            Movie::create($validated);

            return redirect()->route('movies.index')
                ->with('success', 'Filme cadastrado com sucesso!');

        } catch (\Exception $e) {
            Log::error('Erro ao cadastrar filme: ' . $e->getMessage());
            return redirect()->route('movies.index')
                ->with('error', 'Erro ao cadastrar filme. Por favor, tente novamente.');
        }
    }

    public function destroy(Movie $movie)
    {
        try {
            $movie->delete();
            return redirect()->route('movies.index')
                ->with('success', 'Filme excluído com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao excluir filme: ' . $e->getMessage());
            return redirect()->route('movies.index')
                ->with('error', 'Erro ao excluir filme. Por favor, tente novamente.');
        }
    }
}
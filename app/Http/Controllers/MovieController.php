<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $movies = Movie::orderBy('id', 'asc')->get();
        $generos = ['Ação', 'Aventura', 'Comédia', 'Drama', 'Ficção Científica', 'Romance', 'Terror', 'Suspense', 'Documentário', 'Animação'];
        return view('movies.index', compact('movies', 'generos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'ano' => 'required|integer|min:1900|max:' . (date('Y')),
            'codigo' => 'required|integer|unique:movies,codigo',
            'genero' => 'required|string',
        ]);
        
        $validated['disponivel'] = 1;
    
        try {
            Movie::create($validated);
    
            return redirect()->route('movies.index')
                ->with('success', 'Filme cadastrado com sucesso!');
    
        } catch (\Exception $e) {
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
            return redirect()->route('movies.index')
                ->with('error', 'Erro ao excluir filme. Por favor, tente novamente.');
        }
    }

    public function update(Request $request, Movie $movie)
    {
        $messages = [
            'nome.required' => 'O nome do filme é obrigatório',
            'ano.required' => 'O ano do filme é obrigatório',
            'ano.integer' => 'O ano deve ser um número inteiro',
            'codigo.required' => 'O código do filme é obrigatório',
            'codigo.integer' => 'O código deve ser um número inteiro',
            'codigo.unique' => 'Este código já está em uso',
            'genero.required' => 'O gênero do filme é obrigatório'
        ];
    
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'ano' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'codigo' => 'required|integer|unique:movies,codigo,' . $movie->id,
            'genero' => 'required|string'
        ], $messages);
    
        try {
            $validated['disponivel'] = $request->disponivel ? 1 : 0;
            
            $movie->update($validated);
            
            return redirect()->route('movies.index')
                ->with('success', 'Filme atualizado com sucesso!');
                
        } catch (\Exception $e) {
            return redirect()->route('movies.index')
                ->with('error', 'Erro ao atualizar filme. Por favor, tente novamente.');
        }
    }
}
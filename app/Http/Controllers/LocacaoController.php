<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class LocacaoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $movies = Movie::orderBy('id', 'asc')->get();
        return view('locacoes.index', compact('movies'));
    }
}
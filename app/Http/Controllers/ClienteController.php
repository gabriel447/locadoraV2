<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $clientes = Cliente::orderBy('id', 'asc')->get();
        return view('clientes.index', compact('clientes'));
    }

    public function store(Request $request)
    {
        $messages = [
            'nome.required' => 'O nome do cliente é obrigatório',
            'idade.required' => 'A idade do cliente é obrigatória',
            'idade.integer' => 'A idade deve ser um número inteiro',
            'cpf.required' => 'O CPF do cliente é obrigatório',
            'cpf.unique' => 'Este CPF já está cadastrado',
            'cep.required' => 'O CEP é obrigatório',
            'rua.required' => 'A rua é obrigatória',
            'numero.required' => 'O número é obrigatório',
            'cidade.required' => 'A cidade é obrigatória',
            'bairro.required' => 'O bairro é obrigatório',
        ];

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'idade' => 'required|integer|min:1',
            'cpf' => 'required|string|unique:clientes,cpf',
            'cep' => 'required|string',
            'rua' => 'required|string',
            'numero' => 'required|string',
            'cidade' => 'required|string',
            'bairro' => 'required|string',
            'complemento' => 'nullable|string',
        ], $messages);
    
        try {
            Cliente::create($validated);
    
            return redirect()->route('clientes.index')
                ->with('success', 'Cliente cadastrado com sucesso!');
    
        } catch (\Exception $e) {
            return redirect()->route('clientes.index')
                ->with('error', 'Erro ao cadastrar cliente. Por favor, tente novamente.');
        }
    }

    public function destroy(Cliente $cliente)
    {
        try {
            $cliente->delete();
            return redirect()->route('clientes.index')
                ->with('success', 'Cliente excluído com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('clientes.index')
                ->with('error', 'Erro ao excluir cliente. Por favor, tente novamente.');
        }
    }

    public function update(Request $request, Cliente $cliente)
    {
        $messages = [
            'nome.required' => 'O nome do cliente é obrigatório',
            'idade.required' => 'A idade do cliente é obrigatória',
            'idade.integer' => 'A idade deve ser um número inteiro',
            'cpf.required' => 'O CPF do cliente é obrigatório',
            'cpf.unique' => 'Este CPF já está cadastrado',
            'cep.required' => 'O CEP é obrigatório',
            'rua.required' => 'A rua é obrigatória',
            'numero.required' => 'O número é obrigatório',
            'cidade.required' => 'A cidade é obrigatória',
            'bairro.required' => 'O bairro é obrigatório',
        ];
    
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'idade' => 'required|integer|min:1',
            'cpf' => 'required|string|unique:clientes,cpf,' . $cliente->id,
            'cep' => 'required|string',
            'rua' => 'required|string',
            'numero' => 'required|string',
            'cidade' => 'required|string',
            'bairro' => 'required|string',
            'complemento' => 'nullable|string',
        ], $messages);
    
        try {
            $cliente->update($validated);
            
            return redirect()->route('clientes.index')
                ->with('success', 'Cliente atualizado com sucesso!');
                
        } catch (\Exception $e) {
            return redirect()->route('clientes.index')
                ->with('error', 'Erro ao atualizar cliente. Por favor, tente novamente.');
        }
    }
}
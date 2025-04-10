<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cadastro;
use App\Models\CadastroHistorico;
use Carbon\Carbon;

class FormularioController extends Controller
{
    
    public function create()
    {
        return view('formulario.create');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefone' => 'required|string|max:20',
            'cep' => 'required|string|max:10',
            'estado_civil' => 'required|string|max:50',
            'time' => 'required|string|max:100',
            'profissao' => 'required|string|max:100',
            'salario' => 'required|numeric',
        ]);

        $cadastro = Cadastro::create($validated);

        return redirect()->route('formulario.show')->with('success', 'Cadastro realizado com sucesso!');
    }


    public function show()
    {
        $cadastros = Cadastro::all();
        return view('formulario.show', compact('cadastros'));
    }


    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefone' => 'required|string|max:20',
            'cep' => 'required|string|max:10',
            'estado_civil' => 'required|string|max:50',
            'time' => 'required|string|max:100',
            'profissao' => 'required|string|max:100',
            'salario' => 'required|numeric',
        ]);


        $cadastro = Cadastro::findOrFail($id);

        $historico = new CadastroHistorico();
        $historico->original_id = $cadastro->id;
        $historico->nome = $cadastro->nome;
        $historico->email = $cadastro->email;
        $historico->telefone = $cadastro->telefone;
        $historico->cep = $cadastro->cep;
        $historico->estado_civil = $cadastro->estado_civil;
        $historico->time = $cadastro->time;
        $historico->profissao = $cadastro->profissao;
        $historico->salario = $cadastro->salario;
        $historico->save();
        

        $cadastro->update($validated);
        

        return redirect()->route('formulario.show')->with('success', 'Cadastro atualizado com sucesso!');
    }
}

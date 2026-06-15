<?php

namespace App\Http\Controllers;

use App\Models\Responsavel;
use Illuminate\Http\Request;

class ResponsavelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $responsaveis = Responsavel::all();

        return view(
            'responsaveis.index',
            compact('responsaveis')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $nomes = [
            'João Silva',
            'Maria Santos',
            'Carlos Oliveira',
            'Ana Souza',
            'Pedro Lima',
            'Lucas Costa',
            'Juliana Rocha',
            'Fernanda Alves',
            'Bruno Martins',
            'Gabriel Ferreira',
            'Amanda Ribeiro',
            'Rodrigo Melo',
            'Camila Carvalho',
            'Rafael Teixeira',
            'Larissa Gomes',
            'Diego Almeida',
            'Beatriz Barbosa',
            'Guilherme Pinto',
            'Letícia Correia',
            'Gustavo Cardoso',
            'Mariana Cavalcanti',
            'Felipe Dias',
            'Sofia Castro',
            'Thiago Cunha',
            'Bárbara Fernandes',
            'Mateus Fontana',
            'Carolina Moura',
            'Leonardo Rocha',
            'Gabriela Nunes',
            'Vitor Mendes',
            'Isabela Vieira',
            'Daniel Marques',
            'Manuela Medeiros',
            'Eduardo Nascimento',
            'Alice Ramos',
            'André Moraes',
            'Luana Freitas',
            'Samuel Santana',
            'Olivia Azevedo',
            'Caio Pereira',
            'Laura Borges',
            'Henrique Rezende',
            'Valentina Farias',
            'Murilo Aragão',
            'Heloísa Guimarães',
            'Vinícius Assis',
            'Lorena Viana',
            'Arthur Lopes',
            'Cecília Machado',
            'Matheus Nogueira'
        ];
        Responsavel::create([
            'nome' => $nomes[array_rand($nomes)],
            'ativo' => true
        ]);

        return redirect()->route('responsaveis.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Responsavel $responsavel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Responsavel $responsavel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Responsavel $responsavel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Responsavel $responsavel)
    {
        //
    }
}

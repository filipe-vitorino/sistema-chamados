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
        Responsavel::create([
            'nome' => Responsavel::gerarNomeAleatorio(),
            'ativo' => true
        ]);

        return redirect()->route('responsaveis.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Responsavel $responsavel)
    {
        $query = $responsavel->chamados()->whereIn('status', ['aberto', 'em_andamento']);
        $ordenacao = $request->input('ordenar_por', 'chegada');

        if ($ordenacao === 'prioridade') {
            $query->orderByRaw("FIELD(prioridade, 'alta', 'media', 'baixa') ASC");
        } else {
            $query->orderBy('created_at', 'asc');
        }

        $chamados = $query->get();

        return view('responsaveis.chamados', compact('responsavel', 'chamados', 'ordenacao'));
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

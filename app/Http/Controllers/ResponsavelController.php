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
        $chamadosAnteriores = $responsavel->chamadosAnteriores();
        return view('responsaveis.chamados', compact('responsavel', 'chamados', 'ordenacao', 'chamadosAnteriores'));
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
    public function toggle(Responsavel $responsavel)
    {
        if ($responsavel->ativo) {

            $possuiChamadosPendentes = $responsavel
                ->chamados()
                ->whereIn('status', [
                    'aberto',
                    'em_andamento'
                ])
                ->exists();

            if ($possuiChamadosPendentes) {

                return redirect()
                    ->route('responsaveis.index')
                    ->with(
                        'erro',
                        'Não é possível desativar um responsável com chamados pendentes.'
                    );
            }
        }

        $responsavel->ativo = !$responsavel->ativo;

        $responsavel->save();

        return redirect()
            ->route('responsaveis.index');
    }

    public function chamados(Responsavel $responsavel, Request $request)
    {
        $ordenacao = $request->get('ordenacao', 'recentes');

        if ($request->status === 'anteriores') {
            $chamados = $responsavel->chamadosAnteriores();
        } else {
            $query = $responsavel->chamados()
                ->when($request->status, fn($query, $status) => $query->where('status', $status))
                ->when($request->prioridade, fn($query, $prioridade) => $query->where('prioridade', $prioridade));

            match ($ordenacao) {
                'antigos'          => $query->orderBy('created_at', 'asc'),
                'prioridade_alta'  => $query->orderByRaw("CASE prioridade WHEN 'alta' THEN 1 WHEN 'media' THEN 2 WHEN 'baixa' THEN 3 END"),
                'prioridade_baixa' => $query->orderByRaw("CASE prioridade WHEN 'baixa' THEN 1 WHEN 'media' THEN 2 WHEN 'alta' THEN 3 END"),
                default            => $query->orderBy('created_at', 'desc'),
            };

            $chamados = $query->get();
        }

        return view('responsaveis.chamados', compact('responsavel', 'chamados'));
        //return response()->json($chamados);
    }
}

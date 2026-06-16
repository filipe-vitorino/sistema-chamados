<?php

namespace App\Http\Controllers;

use App\Models\Chamado;
use App\Models\Responsavel;
use Illuminate\Http\Request;

class ChamadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Chamado::with('responsavel');

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        if ($request->filled('prioridade')) {
            $query->where(
                'prioridade',
                $request->prioridade
            );
        }

        if ($request->filled('responsavel_id')) {
            $query->where(
                'responsavel_id',
                $request->responsavel_id
            );
        }

        $chamados = $query
            ->latest()
            ->get();

        $responsaveis =
            Responsavel::orderBy('nome')
            ->get();

        return view(
            'chamados.index',
            compact(
                'chamados',
                'responsaveis'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $responsaveis = Responsavel::where('ativo', true)
            ->withCount(['chamados' => function ($query) {
                $query->whereIn('status', [
                    'aberto',
                    'em_andamento'
                ]);
            }])
            ->orderBy('chamados_count')
            ->get();

        $responsavelSugerido =
            Responsavel::obterMenosOcupado();

        return view(
            'chamados.create',
            compact(
                'responsaveis',
                'responsavelSugerido'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'titulo' => 'required|max:255',
            'descricao' => 'required',
            'prioridade' => 'required',
            'responsavel_id' => 'required|exists:responsaveis,id',
        ]);

        Chamado::create([
            'titulo' => $dados['titulo'],
            'descricao' => $dados['descricao'],
            'prioridade' => $dados['prioridade'],
            'status' => 'aberto',
            'responsavel_id' =>
            $dados['responsavel_id'],
        ]);

        return redirect()
            ->route('chamados.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Chamado $chamado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chamado $chamado)
    {
        $responsaveis = Responsavel::where(
            'ativo',
            true
        )->orderBy('nome')
            ->get();

        return view(
            'chamados.edit',
            compact(
                'chamado',
                'responsaveis'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chamado $chamado)
    {
        $dados = $request->validate([
            'status' =>
            'required|in:aberto,em_andamento,resolvido',

            'responsavel_id' =>
            'required|exists:responsaveis,id',
        ]);
        if (
            $dados['status'] === 'resolvido'
            && $chamado->status !== 'resolvido'
        ) {
            $dados['resolvido_em'] = now();
        }

        if (
            $dados['status'] !== 'resolvido'
            && $chamado->status === 'resolvido'
        ) {
            $dados['resolvido_em'] = null;
        }
        $chamado->update($dados);

        return redirect()
            ->route('chamados.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chamado $chamado)
    {
        //
    }
}

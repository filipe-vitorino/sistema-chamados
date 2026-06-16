@extends('layouts.app')

@section('title', 'Chamados')

@section('content')

<h1 class="mb-4">
    Chamados
</h1>

<div class="mb-3">

    <a href="{{ route('chamados.create') }}" class="btn btn-codificar">
    <i class="fa-solid fa-plus me-2"></i> Novo Chamado
</a>

</div>

<form method="GET" class="mb-4">
    <div class="row">
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">Todos os Status</option>
                <option value="aberto" @selected(request('status') == 'aberto')>Aberto</option>
                <option value="em_andamento" @selected(request('status') == 'em_andamento')>Em andamento</option>
                <option value="resolvido" @selected(request('status') == 'resolvido')>Resolvido</option>
            </select>
        </div>

        <div class="col-md-3">
            <select name="prioridade" class="form-select">
                <option value="">Todas as Prioridades</option>
                <option value="alta" @selected(request('prioridade') == 'alta')>Alta</option>
                <option value="media" @selected(request('prioridade') == 'media')>Média</option>
                <option value="baixa" @selected(request('prioridade') == 'baixa')>Baixa</option>
            </select>
        </div>

        <div class="col-md-3">
            <select name="responsavel_id" class="form-select">
                <option value="">Todos os Responsáveis</option>
                @foreach($responsaveis as $responsavel)
                    <option value="{{ $responsavel->id }}" @selected(request('responsavel_id') == $responsavel->id)>
                        {{ $responsavel->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <button type="submit" class="btn btn-dark w-100">
                <i class="fa-solid fa-filter me-2"></i> Filtrar
            </button>
        </div>
    </div>
</form>

<table class="table table-striped">

    <thead>

        <tr>

            <th>ID</th>

            <th>Título</th>

            <th>Responsável</th>

            <th>Prioridade</th>

            <th>Status</th>

            <th>Resolvido em</th>

            <th>Ações</th>

        </tr>

    </thead>

    <tbody>

        @foreach($chamados as $chamado)

            <tr>

                <td>
                    {{ $chamado->id }}
                </td>

                <td>
                    {{ $chamado->titulo }}
                </td>

                <td>
                    {{ $chamado->responsavel->nome }}
                </td>

                <td>
                    {{ ucfirst($chamado->prioridade) }}
                </td>

                <td>
                    {{ ucfirst(str_replace('_', ' ', $chamado->status)) }}
                </td>

                <td>
                    @if($chamado->resolvido_em)
                        {{ $chamado->resolvido_em->format('d/m/Y H:i') }}
                    @else
                        -
                    @endif
                </td>

                <td>

                    <a href="{{ route('chamados.show', $chamado) }}" class="btn btn-sm btn-info text-white">
    <i class="fa-solid fa-clock-rotate-left"></i> Histórico
</a>
<a href="{{ route('chamados.edit', $chamado) }}" class="btn btn-sm btn-warning">
    <i class="fa-solid fa-pen"></i> Editar
</a>

                </td>

            </tr>

        @endforeach

    </tbody>

</table>

@endsection
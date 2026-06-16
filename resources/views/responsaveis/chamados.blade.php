@extends('layouts.app')

@section('title', 'Chamados do Responsável')

@section('content')

<h1 class="mb-4">
    Chamados de {{ $responsavel->nome }}
</h1>

<form method="GET" class="mb-4">

    <div class="row">

        <div class="col-md-3">

            <label class="form-label">
                Status
            </label>

            <select
                name="status"
                class="form-select">

                <option value="">
                    Todos
                </option>

                <option
                    value="aberto"
                    {{ request('status') == 'aberto' ? 'selected' : '' }}>
                    Aberto
                </option>

                <option
                    value="em_andamento"
                    {{ request('status') == 'em_andamento' ? 'selected' : '' }}>
                    Em andamento
                </option>

                <option
                    value="resolvido"
                    {{ request('status') == 'resolvido' ? 'selected' : '' }}>
                    Resolvido
                </option>

            </select>

        </div>

        <div class="col-md-3">

            <label class="form-label">
                Prioridade
            </label>

            <select
                name="prioridade"
                class="form-select">

                <option value="">
                    Todas
                </option>

                <option
                    value="alta"
                    {{ request('prioridade') == 'alta' ? 'selected' : '' }}>
                    Alta
                </option>

                <option
                    value="media"
                    {{ request('prioridade') == 'media' ? 'selected' : '' }}>
                    Média
                </option>

                <option
                    value="baixa"
                    {{ request('prioridade') == 'baixa' ? 'selected' : '' }}>
                    Baixa
                </option>

            </select>

        </div>

        <div class="col-md-4">

            <label class="form-label">
                Ordenação
            </label>

            <select
                name="ordenacao"
                class="form-select">

                <option
                    value="recentes"
                    {{ request('ordenacao') == 'recentes' ? 'selected' : '' }}>
                    Mais recentes
                </option>

                <option
                    value="antigos"
                    {{ request('ordenacao') == 'antigos' ? 'selected' : '' }}>
                    Mais antigos
                </option>

                <option
                    value="prioridade_alta"
                    {{ request('ordenacao') == 'prioridade_alta' ? 'selected' : '' }}>
                    Prioridade alta primeiro
                </option>

                <option
                    value="prioridade_baixa"
                    {{ request('ordenacao') == 'prioridade_baixa' ? 'selected' : '' }}>
                    Prioridade baixa primeiro
                </option>

            </select>

        </div>

        <div class="col-md-2 d-flex align-items-end">

            <button
                type="submit"
                class="btn btn-primary w-100">
                Filtrar
            </button>

        </div>

    </div>

</form>

<div class="card">

    <div class="card-header">
        Lista de Chamados
    </div>

    <div class="card-body">

        @if($chamados->isEmpty())

            <div class="alert alert-info">
                Nenhum chamado encontrado.
            </div>

        @else

            <table class="table table-striped">

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Prioridade</th>
                        <th>Status</th>
                        <th>Data de Criação</th>
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

                                @if($chamado->prioridade == 'alta')
                                    <span class="badge bg-danger">
                                        Alta
                                    </span>

                                @elseif($chamado->prioridade == 'media')
                                    <span class="badge bg-warning text-dark">
                                        Média
                                    </span>

                                @else
                                    <span class="badge bg-success">
                                        Baixa
                                    </span>
                                @endif

                            </td>

                            <td>

                                @if($chamado->status == 'aberto')
                                    <span class="badge bg-primary">
                                        Aberto
                                    </span>

                                @elseif($chamado->status == 'em_andamento')
                                    <span class="badge bg-warning text-dark">
                                        Em andamento
                                    </span>

                                @else
                                    <span class="badge bg-success">
                                        Resolvido
                                    </span>
                                @endif

                            </td>

                            <td>
                                {{ $chamado->created_at->format('d/m/Y H:i') }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @endif

    </div>

</div>

<div class="mt-3">

    <a
        href="{{ route('responsaveis.index') }}"
        class="btn btn-secondary">

        Voltar

    </a>

</div>

@endsection
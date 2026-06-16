@extends('layouts.app')

@section('title', 'Chamados')

@section('content')

<h1 class="mb-4">
    Chamados
</h1>

<div class="mb-3">

    <a
        href="{{ route('chamados.create') }}"
        class="btn btn-success">

        Novo Chamado

    </a>

</div>

<form
    method="GET"
    class="mb-4">

    <div class="row">

        <div class="col-md-3">

            <select
                name="status"
                class="form-select">

                <option value="">
                    Todos os Status
                </option>

                <option value="aberto">
                    Aberto
                </option>

                <option value="em_andamento">
                    Em andamento
                </option>

                <option value="resolvido">
                    Resolvido
                </option>

            </select>

        </div>

        <div class="col-md-3">

            <select
                name="prioridade"
                class="form-select">

                <option value="">
                    Todas as Prioridades
                </option>

                <option value="alta">
                    Alta
                </option>

                <option value="media">
                    Média
                </option>

                <option value="baixa">
                    Baixa
                </option>

            </select>

        </div>

        <div class="col-md-3">

            <select
                name="responsavel_id"
                class="form-select">

                <option value="">
                    Todos os Responsáveis
                </option>

                @foreach($responsaveis as $responsavel)

                    <option
                        value="{{ $responsavel->id }}">

                        {{ $responsavel->nome }}

                    </option>

                @endforeach

            </select>

        </div>

        <div class="col-md-3">

            <button
                class="btn btn-primary w-100">

                Filtrar

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

                    <a
                        href="{{ route('chamados.show', $chamado) }}"
                        class="btn btn-sm btn-info">

                        Ver

                    </a>

                    <a
                        href="{{ route('chamados.edit', $chamado) }}"
                        class="btn btn-sm btn-warning">

                        Status

                    </a>

                </td>

            </tr>

        @endforeach

    </tbody>

</table>

@endsection
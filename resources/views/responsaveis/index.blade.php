@extends('layouts.app')

@section('title', 'Responsáveis')

@section('content')

<h1 class="mb-4">Responsáveis</h1>

<form action="{{ route('responsaveis.store') }}"
      method="POST"
      class="mb-3">
    @csrf

    <button type="submit"
            class="btn btn-primary">
        + Adicionar Responsável
    </button>
</form>

<table class="table table-striped">

    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Ativo</th>
            <th>Ações</th>
        </tr>
    </thead>

    <tbody>

        @foreach($responsaveis as $responsavel)

            <tr>

                <td>{{ $responsavel->id }}</td>

                <td>{{ $responsavel->nome }}</td>

                <td>
                    {{ $responsavel->ativo ? 'Sim' : 'Não' }}
                </td>

                <td>

                    <form action="{{ route('responsaveis.toggle', $responsavel) }}"
                          method="POST">

                        @csrf
                        @method('PATCH')

                        <button type="submit"
                                class="btn btn-sm btn-warning">

                            {{ $responsavel->ativo ? 'Desativar' : 'Ativar' }}

                        </button>

                    </form>

                </td>
                <td>
                <a href="{{ route('responsaveis.chamados', $responsavel) }}"
                    class="btn btn-sm btn-info">
                    Chamados
                </a>
                </td>
            </tr>

        @endforeach

    </tbody>

</table>

@endsection
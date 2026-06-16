@if(session('erro'))

    <div class="alert alert-danger">

        {{ session('erro') }}

    </div>

@endif


@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<h1 class="mb-4">Dashboard</h1>

<div class="row">

    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6>Responsáveis Ativos</h6>

                <h2>
                    {{ $responsaveisAtivos }}
                </h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6>Chamados Abertos</h6>

                <h2>
                    {{ $chamadosAbertos }}
                </h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6>Em Andamento</h6>

                <h2>
                    {{ $chamadosAndamento }}
                </h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6>Resolvidos</h6>

                <h2>
                    {{ $chamadosResolvidos }}
                </h2>
            </div>
        </div>
    </div>

</div>

<div class="card mt-4">

    <div class="card-header">
        Últimos Chamados
    </div>

    <div class="card-body">

        @if($ultimosChamados->isEmpty())

            <p>Nenhum chamado cadastrado.</p>

        @else

            <table class="table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($ultimosChamados as $chamado)

                        <tr>

                            <td>
                                {{ $chamado->id }}
                            </td>

                            <td>
                                {{ $chamado->titulo }}
                            </td>

                            <td>
                                {{ $chamado->status }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @endif

    </div>

</div>

<div class="mt-4">

    <a href="{{ route('responsaveis.index') }}"
       class="btn btn-primary">
        Gerenciar Responsáveis
    </a>

    <a href="{{ route('chamados.index') }}"
       class="btn btn-success">
        Gerenciar Chamados
    </a>

</div>

@endsection
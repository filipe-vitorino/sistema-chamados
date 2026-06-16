@extends('layouts.app')

@section('content')

<h1>
    Chamado #{{ $chamado->id }}
</h1>

<div class="card mb-4">

    <div class="card-body">

        <p>
            <strong>Título:</strong>
            {{ $chamado->titulo }}
        </p>

        <p>
            <strong>Status:</strong>
            {{ $chamado->status }}
        </p>

        <p>
            <strong>Responsável:</strong>
            {{ $chamado->responsavel->nome }}
        </p>

    </div>

</div>

<div class="card">

    <div class="card-header">
        Histórico
    </div>

    <div class="card-body">

        @foreach(
            $chamado->historicos
                ->sortByDesc('created_at')
            as $historico
        )

            <div class="mb-3">

                <strong>
                    {{ $historico->created_at->format('d/m/Y H:i') }}
                </strong>

                <br>

                {{ $historico->descricao }}

            </div>

            <hr>

        @endforeach

    </div>

</div>

@endsection
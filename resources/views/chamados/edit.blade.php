@extends('layouts.app')

@section('title', 'Editar Chamado')

@section('content')

<h1 class="mb-4">
    Editar Chamado #{{ $chamado->id }}
</h1>

<div class="card mb-4">

    <div class="card-body">

        <p>
            <strong>Título:</strong>
            {{ $chamado->titulo }}
        </p>

        <p>
            <strong>Descrição:</strong>
            {{ $chamado->descricao }}
        </p>

        <p>
            <strong>Prioridade:</strong>
            {{ ucfirst($chamado->prioridade) }}
        </p>

    </div>

</div>

<form
    action="{{ route('chamados.update', $chamado) }}"
    method="POST">

    @csrf
    @method('PUT')

    <div class="mb-3">

        <label class="form-label">
            Responsável
        </label>

        <select
            name="responsavel_id"
            class="form-select">

            @foreach($responsaveis as $responsavel)

                <option
                    value="{{ $responsavel->id }}"
                    {{ $responsavel->id ==
                       $chamado->responsavel_id
                        ? 'selected'
                        : ''
                    }}>

                    {{ $responsavel->nome }}

                </option>

            @endforeach

        </select>

    </div>

    <div class="mb-3">

        <label class="form-label">
            Status
        </label>

        <select
            name="status"
            class="form-select">

            <option
                value="aberto"
                {{ $chamado->status == 'aberto'
                    ? 'selected'
                    : ''
                }}>
                Aberto
            </option>

            <option
                value="em_andamento"
                {{ $chamado->status == 'em_andamento'
                    ? 'selected'
                    : ''
                }}>
                Em andamento
            </option>

            <option
                value="resolvido"
                {{ $chamado->status == 'resolvido'
                    ? 'selected'
                    : ''
                }}>
                Resolvido
            </option>

        </select>

    </div>

    <button
        class="btn btn-primary">

        Salvar Alterações

    </button>

    <a
        href="{{ route('chamados.index') }}"
        class="btn btn-secondary">

        Cancelar

    </a>

</form>

@endsection
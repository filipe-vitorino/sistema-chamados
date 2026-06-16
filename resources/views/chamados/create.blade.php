@extends('layouts.app')

@section('title', 'Novo Chamado')

@section('content')

<h1 class="mb-4">
    Novo Chamado
</h1>

<form
    action="{{ route('chamados.store') }}"
    method="POST">

    @csrf

    <div class="mb-3">

        <label class="form-label">
            Título
        </label>

        <input
            type="text"
            name="titulo"
            class="form-control"
            required>

    </div>

    <div class="mb-3">

        <label class="form-label">
            Descrição
        </label>

        <textarea
            name="descricao"
            rows="4"
            class="form-control"
            required></textarea>

    </div>

    <div class="mb-3">

        <label class="form-label">
            Prioridade
        </label>

        <select
            name="prioridade"
            class="form-select">

            <option value="baixa">
                Baixa
            </option>

            <option value="media">
                Média
            </option>

            <option value="alta">
                Alta
            </option>

        </select>

    </div>

    <div class="mb-3">

        <label class="form-label">
            Responsável
        </label>

        <select
            name="responsavel_id"
            class="form-select">

            @foreach(
                $responsaveis
                as $responsavel
            )

                <option
                    value="{{ $responsavel->id }}"
                    {{ $responsavelSugerido &&
                       $responsavel->id ==
                       $responsavelSugerido->id
                        ? 'selected'
                        : ''
                    }}>

                    {{ $responsavel->nome }}

                     @if(
                        $responsavelSugerido &&
                        $responsavel->id == $responsavelSugerido->id
                    )
                     (Sugerido)
                     @endif

                </option>

            @endforeach

        </select>

    </div>

    <button
        type="submit"
        class="btn btn-success">

        Criar Chamado

    </button>

</form>

@endsection
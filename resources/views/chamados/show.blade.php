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
            {{ ucfirst(str_replace('_', ' ', $chamado->status)) }}
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

        @if($chamado->historicos->isEmpty())
            <p class="text-muted">Nenhum histórico registrado para este chamado.</p>
        @else
            @foreach($chamado->historicos->sortByDesc('created_at') as $historico)
                <div class="mb-3">
                    <strong>
                        {{ $historico->created_at->format('d/m/Y H:i') }}
                    </strong>
                    <br>

                    @if($historico->campo_alterado === 'criacao')
                        <span class="text-success">Chamado criado.</span>
                        
                    @elseif($historico->campo_alterado === 'status')
                        Status alterado de <strong>{{ ucfirst(str_replace('_', ' ', $historico->valor_antigo)) }}</strong> para <strong>{{ ucfirst(str_replace('_', ' ', $historico->valor_novo)) }}</strong>.
                        
                    @elseif($historico->campo_alterado === 'responsavel_id')
                        @php
                            $antigo = \App\Models\Responsavel::find($historico->valor_antigo);
                            $novo = \App\Models\Responsavel::find($historico->valor_novo);
                        @endphp
                        Responsável transferido de <strong>{{ $antigo ? $antigo->nome : 'Nenhum' }}</strong> para <strong>{{ $novo ? $novo->nome : 'Usuário Removido' }}</strong>.
                        
                    @else
                        Campo {{ ucfirst($historico->campo_alterado) }} alterado.
                    @endif
                </div>
                <hr>
            @endforeach
        @endif

    </div>
</div>

@endsection
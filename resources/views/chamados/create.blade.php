@extends('layouts.app')

@section('title', 'Novo Chamado')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>
        <i class="fa-solid fa-square-plus text-success me-2"></i>Novo Chamado
    </h1>
    <a href="{{ route('chamados.index') }}" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left me-2"></i>Voltar para Listagem
    </a>
</div>

<div class="card">
    <div class="card-header bg-white py-3">
        <h5 class="card-title mb-0 text-muted">Preencha as informações do novo pedido</h5>
    </div>
    <div class="card-body p-4">
        
        <form action="{{ route('chamados.store') }}" method="POST" id="form-chamado">
            @csrf

            <div class="mb-4">
                <label for="titulo" class="form-label fw-bold">Título do Chamado</label>
                <input 
                    type="text" 
                    name="titulo" 
                    id="titulo" 
                    class="form-control @error('titulo') is-invalid @enderror" 
                    value="{{ old('titulo') }}" 
                    placeholder="Ex: Meu computador não liga ou Impressora travada"
                    required
                >
                @error('titulo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="descricao" class="form-label fw-bold">Descrição Detalhada</label>
                <textarea 
                    name="descricao" 
                    id="descricao" 
                    rows="4" 
                    class="form-control @error('descricao') is-invalid @enderror" 
                    placeholder="Descreva aqui o problema com o máximo de detalhes possível..."
                    required
                >{{ old('descricao') }}</textarea>
                @error('descricao')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="prioridade" class="form-label fw-bold">Prioridade</label>
                    <select name="prioridade" id="prioridade" class="form-select @error('prioridade') is-invalid @enderror" required>
                        <option value="" disabled selected>Selecione uma prioridade</option>
                        <option value="baixa" @selected(old('prioridade') == 'baixa')>Baixa</option>
                        <option value="media" @selected(old('prioridade') == 'media')>Média</option>
                        <option value="alta" @selected(old('prioridade') == 'alta')>Alta</option>
                    </select>
                    @error('prioridade')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-4">
                    <label for="responsavel_id" class="form-label fw-bold">Responsável pelo Atendimento</label>
                    <select name="responsavel_id" id="responsavel_id" class="form-select @error('responsavel_id') is-invalid @enderror" required>
                        <option value="" disabled selected>Selecione um profissional</option>
                        @foreach($responsaveis as $responsavel)
                            <option value="{{ $responsavel->id }}" @selected(old('responsavel_id') == $responsavel->id)>
                                {{ $responsavel->nome }} ({{ $responsavel->chamados_count }} chamados ativos)
                            </option>
                        @endforeach
                    </select>
                    @error('responsavel_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="card bg-light mb-4 border-0">
                <div class="card-body">
                    <div class="form-check form-switch fs-5">
                        <input class="form-check-input" type="checkbox" id="atribuir_automatico">
                        <label class="form-check-label fs-6 fw-bold" for="atribuir_automatico">
                            <i class="fa-solid fa-robot text-success me-1"></i> Atribuição Inteligente Automática
                        </label>
                    </div>
                    <div class="text-muted small ms-5 mt-1">
                        Ao ativar, o sistema selecionará o técnico com menor carga de trabalho atual. 
                        @if($responsavelSugerido)
                            A sugestão atual do sistema é: <strong class="text-dark">{{ $responsavelSugerido->nome }}</strong>.
                        @endif
                    </div>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-codificar btn-lg px-5">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Salvar Chamado
                </button>
            </div>

        </form>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkbox = document.getElementById('atribuir_automatico');
        const selectResponsavel = document.getElementById('responsavel_id');
        const form = document.getElementById('form-chamado');
        
        const sugeridoId = "{{ $responsavelSugerido->id ?? '' }}";
        
        let valorManualAnterior = selectResponsavel.value;

        checkbox.addEventListener('change', function () {
            if (this.checked) {
                valorManualAnterior = selectResponsavel.value;
                
                selectResponsavel.value = sugeridoId;
                selectResponsavel.disabled = true;
            } else {
                selectResponsavel.disabled = false;
                selectResponsavel.value = valorManualAnterior;
            }
        });

        form.addEventListener('submit', function () {
            selectResponsavel.disabled = false;
        });
    });
</script>

@endsection
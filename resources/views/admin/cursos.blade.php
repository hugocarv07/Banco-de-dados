@extends('layouts.app')

@section('title', 'Gerenciar Cursos')

@section('content')
<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1 class="card-title">📚 Gerenciar Cursos</h1>
            <button onclick="openModal('modalNovoCurso')" class="btn btn-primary">➕ Novo Curso</button>
        </div>
    </div>
    <div class="card-body">
        @if($cursos->count() > 0)
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome do Curso</th>
                            <th>Departamento</th>
                            <th>Duração</th>
                            <th>Total de Alunos</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cursos as $curso)
                            <tr>
                                <td>
                                    <div style="font-weight: 600;">{{ $curso->nome_curso }}</div>
                                </td>
                                <td>{{ $curso->departamento->nome_departamento ?? 'N/A' }}</td>
                                <td>{{ $curso->duracao_semestres }} semestres</td>
                                <td>
                                    <span class="badge badge-info">{{ $curso->alunos->count() }}</span>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <button onclick="editarCurso({{ json_encode($curso) }})" class="btn btn-outline" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">
                                            ✏️ Editar
                                        </button>
                                        <form method="POST" action="{{ route('admin.cursos.destroy', $curso->id_curso) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;" 
                                                    onclick="return confirm('Tem certeza que deseja excluir este curso?')">
                                                🗑️ Excluir
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 3rem; color: var(--secondary-color);">
                <div style="font-size: 4rem; margin-bottom: 1rem;">📚</div>
                <h3>Nenhum curso cadastrado</h3>
                <p>Comece criando o primeiro curso da instituição.</p>
                <button onclick="openModal('modalNovoCurso')" class="btn btn-primary" style="margin-top: 1rem;">
                    Criar Primeiro Curso
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Modal Novo/Editar Curso -->
<div id="modalNovoCurso" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="modalTitulo">Novo Curso</h3>
            <button class="modal-close" onclick="closeModal('modalNovoCurso')">&times;</button>
        </div>
        <form id="formCurso" method="POST" action="{{ route('admin.cursos.store') }}">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="nome_curso">Nome do Curso*</label>
                    <input type="text" id="nome_curso" name="nome_curso" class="form-control" required maxlength="100"
                           placeholder="Ex: Engenharia de Software">
                </div>

                <div class="form-group">
                    <label class="form-label" for="id_departamento">Departamento*</label>
                    <select id="id_departamento" name="id_departamento" class="form-control" required>
                        <option value="">Selecione um departamento</option>
                        @foreach($departamentos as $departamento)
                            <option value="{{ $departamento->id_departamento }}">{{ $departamento->nome_departamento }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="duracao_semestres">Duração (semestres)*</label>
                    <input type="number" id="duracao_semestres" name="duracao_semestres" class="form-control" 
                           required min="1" max="12" placeholder="8">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('modalNovoCurso')">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar Curso</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function editarCurso(curso) {
    document.getElementById('modalTitulo').textContent = 'Editar Curso';
    document.getElementById('formCurso').action = `/admin/cursos/${curso.id_curso}`;
    document.getElementById('formCurso').innerHTML += '<input type="hidden" name="_method" value="PUT">';
    
    document.getElementById('nome_curso').value = curso.nome_curso;
    document.getElementById('id_departamento').value = curso.id_departamento;
    document.getElementById('duracao_semestres').value = curso.duracao_semestres;
    
    openModal('modalNovoCurso');
}

// Reset form when opening for new course
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modalNovoCurso');
    modal.addEventListener('hidden', function() {
        document.getElementById('modalTitulo').textContent = 'Novo Curso';
        document.getElementById('formCurso').action = '{{ route("admin.cursos.store") }}';
        document.getElementById('formCurso').reset();
        
        // Remove method spoofing input if exists
        const methodInput = document.querySelector('input[name="_method"]');
        if (methodInput) {
            methodInput.remove();
        }
    });
});
</script>
@endpush
@endsection
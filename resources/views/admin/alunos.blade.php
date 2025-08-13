@extends('layouts.app')

@section('title', 'Gerenciar Alunos')

@section('content')
<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1 class="card-title">👨‍🎓 Gerenciar Alunos</h1>
            <button onclick="openModal('modalNovoAluno')" class="btn btn-primary">➕ Novo Aluno</button>
        </div>
    </div>
    <div class="card-body">
        @if($alunos->count() > 0)
            <!-- Filtros -->
            <div style="margin-bottom: 1.5rem; padding: 1rem; background: var(--light-color); border-radius: var(--border-radius);">
                <div class="grid grid-3">
                    <div>
                        <label class="form-label">Filtrar por Curso:</label>
                        <select id="filtroCurso" class="form-control" onchange="filtrarTabela()">
                            <option value="">Todos os cursos</option>
                            @foreach($cursos as $curso)
                                <option value="{{ $curso->nome_curso }}">{{ $curso->nome_curso }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Filtrar por Status:</label>
                        <select id="filtroStatus" class="form-control" onchange="filtrarTabela()">
                            <option value="">Todos os status</option>
                            <option value="Ativo">Ativo</option>
                            <option value="Trancado">Trancado</option>
                            <option value="Jubilado">Jubilado</option>
                            <option value="Evadido">Evadido</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Buscar por Nome:</label>
                        <input type="text" id="buscarNome" class="form-control" placeholder="Digite o nome do aluno..." onkeyup="filtrarTabela()">
                    </div>
                </div>
            </div>

            <div style="overflow-x: auto;">
                <table class="table" id="tabelaAlunos">
                    <thead>
                        <tr>
                            <th>Matrícula</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Curso</th>
                            <th>Status</th>
                            <th>Data Nascimento</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alunos as $aluno)
                            <tr>
                                <td style="font-family: 'Courier New', monospace; font-weight: 600;">{{ $aluno->matricula_aluno }}</td>
                                <td>
                                    <div style="font-weight: 600;">{{ $aluno->pessoa->nome }}</div>
                                    <div style="font-size: 0.75rem; color: var(--secondary-color);">CPF: {{ $aluno->pessoa->cpf }}</div>
                                </td>
                                <td>{{ $aluno->pessoa->email }}</td>
                                <td>{{ $aluno->curso->nome_curso ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge badge-{{ $aluno->status_aluno == 'Ativo' ? 'success' : ($aluno->status_aluno == 'Trancado' ? 'warning' : 'danger') }}">
                                        {{ $aluno->status_aluno }}
                                    </span>
                                </td>
                                <td>{{ date('d/m/Y', strtotime($aluno->pessoa->data_nascimento)) }}</td>
                                <td>
                                    <div style="display: flex; gap: 0.25rem;">
                                        <button onclick="verDetalhes({{ json_encode($aluno) }})" class="btn btn-outline" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">
                                            👁️ Ver
                                        </button>
                                        <button onclick="editarAluno({{ json_encode($aluno) }})" class="btn btn-outline" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">
                                            ✏️ Editar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 3rem; color: var(--secondary-color);">
                <div style="font-size: 4rem; margin-bottom: 1rem;">👨‍🎓</div>
                <h3>Nenhum aluno cadastrado</h3>
                <p>Comece adicionando o primeiro aluno da instituição.</p>
                <button onclick="openModal('modalNovoAluno')" class="btn btn-primary" style="margin-top: 1rem;">
                    Cadastrar Primeiro Aluno
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Modal Novo Aluno -->
<div id="modalNovoAluno" class="modal">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h3 class="modal-title">Cadastrar Novo Aluno</h3>
            <button class="modal-close" onclick="closeModal('modalNovoAluno')">&times;</button>
        </div>
        <form method="POST" action="{{ route('admin.alunos.store') }}">
            @csrf
            <div class="modal-body">
                <div class="grid grid-2">
                    <div class="form-group">
                        <label class="form-label" for="nome">Nome Completo*</label>
                        <input type="text" id="nome" name="nome" class="form-control" required maxlength="100">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="cpf">CPF*</label>
                        <input type="text" id="cpf" name="cpf" class="form-control" required maxlength="11" 
                               placeholder="Apenas números">
                    </div>
                </div>

                <div class="grid grid-2">
                    <div class="form-group">
                        <label class="form-label" for="email">Email*</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="data_nascimento">Data de Nascimento*</label>
                        <input type="date" id="data_nascimento" name="data_nascimento" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="telefone">Telefone</label>
                    <input type="text" id="telefone" name="telefone" class="form-control" maxlength="15">
                </div>

                <div class="form-group">
                    <label class="form-label" for="endereco">Endereço</label>
                    <textarea id="endereco" name="endereco" class="form-control" rows="2"></textarea>
                </div>

                <div class="grid grid-2">
                    <div class="form-group">
                        <label class="form-label" for="matricula_aluno">Matrícula*</label>
                        <input type="text" id="matricula_aluno" name="matricula_aluno" class="form-control" required maxlength="20"
                               placeholder="Ex: 2025001">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="id_curso">Curso*</label>
                        <select id="id_curso" name="id_curso" class="form-control" required>
                            <option value="">Selecione um curso</option>
                            @foreach($cursos as $curso)
                                <option value="{{ $curso->id_curso }}">{{ $curso->nome_curso }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('modalNovoAluno')">Cancelar</button>
                <button type="submit" class="btn btn-primary">Cadastrar Aluno</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function filtrarTabela() {
    const filtroCurso = document.getElementById('filtroCurso').value.toLowerCase();
    const filtroStatus = document.getElementById('filtroStatus').value.toLowerCase();
    const buscarNome = document.getElementById('buscarNome').value.toLowerCase();
    const tabela = document.getElementById('tabelaAlunos');
    const linhas = tabela.getElementsByTagName('tr');

    for (let i = 1; i < linhas.length; i++) {
        const linha = linhas[i];
        const nome = linha.cells[1].textContent.toLowerCase();
        const curso = linha.cells[3].textContent.toLowerCase();
        const status = linha.cells[4].textContent.toLowerCase();

        const mostrarLinha = 
            (filtroCurso === '' || curso.includes(filtroCurso)) &&
            (filtroStatus === '' || status.includes(filtroStatus)) &&
            (buscarNome === '' || nome.includes(buscarNome));

        linha.style.display = mostrarLinha ? '' : 'none';
    }
}

function verDetalhes(aluno) {
    alert(`Detalhes do Aluno:\n\nNome: ${aluno.pessoa.nome}\nMatrícula: ${aluno.matricula_aluno}\nCPF: ${aluno.pessoa.cpf}\nEmail: ${aluno.pessoa.email}\nCurso: ${aluno.curso ? aluno.curso.nome_curso : 'N/A'}\nStatus: ${aluno.status_aluno}`);
}

function editarAluno(aluno) {
    alert('Funcionalidade de edição será implementada em breve.');
}

// Máscara para CPF
document.getElementById('cpf').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 11) value = value.slice(0, 11);
    e.target.value = value;
});
</script>
@endpush
@endsection
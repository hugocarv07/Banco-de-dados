@extends('layouts.app')

@section('title', 'Gerenciar Professores')

@section('content')
<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1 class="card-title">👨‍🏫 Gerenciar Professores</h1>
            <button onclick="openModal('modalNovoProfessor')" class="btn btn-primary">➕ Novo Professor</button>
        </div>
    </div>
    <div class="card-body">
        @if($professores->count() > 0)
            <!-- Filtros -->
            <div style="margin-bottom: 1.5rem; padding: 1rem; background: var(--light-color); border-radius: var(--border-radius);">
                <div class="grid grid-3">
                    <div>
                        <label class="form-label">Filtrar por Departamento:</label>
                        <select id="filtroDepartamento" class="form-control" onchange="filtrarTabela()">
                            <option value="">Todos os departamentos</option>
                            @foreach($departamentos as $departamento)
                                <option value="{{ $departamento->nome_departamento }}">{{ $departamento->nome_departamento }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Filtrar por Titulação:</label>
                        <select id="filtroTitulacao" class="form-control" onchange="filtrarTabela()">
                            <option value="">Todas as titulações</option>
                            <option value="Graduado">Graduado</option>
                            <option value="Especialista">Especialista</option>
                            <option value="Mestre">Mestre</option>
                            <option value="Doutor">Doutor</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Buscar por Nome:</label>
                        <input type="text" id="buscarNome" class="form-control" placeholder="Digite o nome do professor..." onkeyup="filtrarTabela()">
                    </div>
                </div>
            </div>

            <div style="overflow-x: auto;">
                <table class="table" id="tabelaProfessores">
                    <thead>
                        <tr>
                            <th>Matrícula</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Departamento</th>
                            <th>Titulação</th>
                            <th>Salário</th>
                            <th>Carga Horária</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($professores as $professor)
                            <tr>
                                <td style="font-family: 'Courier New', monospace; font-weight: 600;">{{ $professor->matricula_professor }}</td>
                                <td>
                                    <div style="font-weight: 600;">{{ $professor->pessoa->nome }}</div>
                                    <div style="font-size: 0.75rem; color: var(--secondary-color);">CPF: {{ $professor->pessoa->cpf }}</div>
                                </td>
                                <td>{{ $professor->pessoa->email }}</td>
                                <td>{{ $professor->departamento->nome_departamento ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge badge-{{ $professor->titulacao == 'Doutor' ? 'success' : ($professor->titulacao == 'Mestre' ? 'info' : 'warning') }}">
                                        {{ $professor->titulacao }}
                                    </span>
                                </td>
                                <td>R$ {{ number_format($professor->salario, 2, ',', '.') }}</td>
                                <td>
                                    {{ $professor->carga_horaria_semanal }}h/semana
                                    @if($professor->carga_horaria_semanal >= 18)
                                        <span style="color: var(--warning-color);">⚠️</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.25rem;">
                                        <button onclick="verDetalhes({{ json_encode($professor) }})" class="btn btn-outline" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">
                                            👁️ Ver
                                        </button>
                                        <button onclick="editarProfessor({{ json_encode($professor) }})" class="btn btn-outline" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">
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
                <div style="font-size: 4rem; margin-bottom: 1rem;">👨‍🏫</div>
                <h3>Nenhum professor cadastrado</h3>
                <p>Comece adicionando o primeiro professor da instituição.</p>
                <button onclick="openModal('modalNovoProfessor')" class="btn btn-primary" style="margin-top: 1rem;">
                    Cadastrar Primeiro Professor
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Modal Novo Professor -->
<div id="modalNovoProfessor" class="modal">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h3 class="modal-title">Cadastrar Novo Professor</h3>
            <button class="modal-close" onclick="closeModal('modalNovoProfessor')">&times;</button>
        </div>
        <form method="POST" action="{{ route('admin.professores.store') }}">
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
                        <label class="form-label" for="matricula_professor">Matrícula*</label>
                        <input type="text" id="matricula_professor" name="matricula_professor" class="form-control" required maxlength="20"
                               placeholder="Ex: PROF2025001">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="salario">Salário*</label>
                        <input type="number" id="salario" name="salario" class="form-control" required min="0" step="0.01"
                               placeholder="0.00">
                    </div>
                </div>

                <div class="grid grid-2">
                    <div class="form-group">
                        <label class="form-label" for="titulacao">Titulação*</label>
                        <select id="titulacao" name="titulacao" class="form-control" required>
                            <option value="">Selecione a titulação</option>
                            <option value="Graduado">Graduado</option>
                            <option value="Especialista">Especialista</option>
                            <option value="Mestre">Mestre</option>
                            <option value="Doutor">Doutor</option>
                        </select>
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
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('modalNovoProfessor')">Cancelar</button>
                <button type="submit" class="btn btn-primary">Cadastrar Professor</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function filtrarTabela() {
    const filtroDepartamento = document.getElementById('filtroDepartamento').value.toLowerCase();
    const filtroTitulacao = document.getElementById('filtroTitulacao').value.toLowerCase();
    const buscarNome = document.getElementById('buscarNome').value.toLowerCase();
    const tabela = document.getElementById('tabelaProfessores');
    const linhas = tabela.getElementsByTagName('tr');

    for (let i = 1; i < linhas.length; i++) {
        const linha = linhas[i];
        const nome = linha.cells[1].textContent.toLowerCase();
        const departamento = linha.cells[3].textContent.toLowerCase();
        const titulacao = linha.cells[4].textContent.toLowerCase();

        const mostrarLinha = 
            (filtroDepartamento === '' || departamento.includes(filtroDepartamento)) &&
            (filtroTitulacao === '' || titulacao.includes(filtroTitulacao)) &&
            (buscarNome === '' || nome.includes(buscarNome));

        linha.style.display = mostrarLinha ? '' : 'none';
    }
}

function verDetalhes(professor) {
    alert(`Detalhes do Professor:\n\nNome: ${professor.pessoa.nome}\nMatrícula: ${professor.matricula_professor}\nCPF: ${professor.pessoa.cpf}\nEmail: ${professor.pessoa.email}\nDepartamento: ${professor.departamento ? professor.departamento.nome_departamento : 'N/A'}\nTitulação: ${professor.titulacao}\nSalário: R$ ${professor.salario}\nCarga Horária: ${professor.carga_horaria_semanal}h/semana`);
}

function editarProfessor(professor) {
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
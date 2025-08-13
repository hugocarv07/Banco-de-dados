@extends('layouts.app')

@section('title', 'Relatório: Alunos por Turma')

@section('content')
<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="card-title">📋 Relatório: Alunos por Turma</h1>
                <div style="color: var(--secondary-color); font-size: 0.875rem; margin-top: 0.25rem;">
                    Lista completa de alunos matriculados por turma/disciplina
                </div>
            </div>
            <div>
                <a href="{{ route('admin.relatorios') }}" class="btn btn-outline">← Voltar aos Relatórios</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if($relatorio->count() > 0)
            <!-- Filtros -->
            <div style="margin-bottom: 1.5rem; padding: 1rem; background: var(--light-color); border-radius: var(--border-radius);">
                <div class="grid grid-3">
                    <div>
                        <label class="form-label">Filtrar por Disciplina:</label>
                        <select id="filtroDisciplina" class="form-control" onchange="filtrarTabela()">
                            <option value="">Todas as disciplinas</option>
                            @foreach($relatorio->unique('nome_disciplina')->sortBy('nome_disciplina') as $item)
                                <option value="{{ $item->nome_disciplina }}">{{ $item->nome_disciplina }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Filtrar por Status:</label>
                        <select id="filtroStatus" class="form-control" onchange="filtrarTabela()">
                            <option value="">Todos os status</option>
                            <option value="Cursando">Cursando</option>
                            <option value="Aprovado">Aprovado</option>
                            <option value="Reprovado">Reprovado</option>
                            <option value="Recuperação">Recuperação</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Buscar Aluno:</label>
                        <input type="text" id="buscarAluno" class="form-control" placeholder="Digite o nome do aluno..." onkeyup="filtrarTabela()">
                    </div>
                </div>
            </div>

            <!-- Resumo Estatístico -->
            <div class="grid grid-4" style="margin-bottom: 2rem;">
                <div class="card" style="border: 1px solid var(--primary-color);">
                    <div class="card-body" style="text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: 600; color: var(--primary-color);">
                            {{ $relatorio->unique('nome_disciplina')->count() }}
                        </div>
                        <div style="color: var(--secondary-color); font-size: 0.875rem;">Disciplinas Ativas</div>
                    </div>
                </div>

                <div class="card" style="border: 1px solid var(--success-color);">
                    <div class="card-body" style="text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: 600; color: var(--success-color);">
                            {{ $relatorio->unique(['nome_aluno', 'nome_disciplina'])->count() }}
                        </div>
                        <div style="color: var(--secondary-color); font-size: 0.875rem;">Total de Matrículas</div>
                    </div>
                </div>

                <div class="card" style="border: 1px solid var(--info-color);">
                    <div class="card-body" style="text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: 600; color: var(--info-color);">
                            {{ $relatorio->unique('nome_aluno')->count() }}
                        </div>
                        <div style="color: var(--secondary-color); font-size: 0.875rem;">Alunos Únicos</div>
                    </div>
                </div>

                <div class="card" style="border: 1px solid var(--warning-color);">
                    <div class="card-body" style="text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: 600; color: var(--warning-color);">
                            {{ number_format($relatorio->groupBy('nome_disciplina')->map->count()->avg(), 1) }}
                        </div>
                        <div style="color: var(--secondary-color); font-size: 0.875rem;">Média por Turma</div>
                    </div>
                </div>
            </div>

            <!-- Tabela Principal -->
            <div style="overflow-x: auto;">
                <table class="table" id="tabelaRelatorio">
                    <thead>
                        <tr>
                            <th>Disciplina</th>
                            <th>Código da Turma</th>
                            <th>Matrícula</th>
                            <th>Nome do Aluno</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($relatorio as $item)
                            <tr>
                                <td>
                                    <div style="font-weight: 600;">{{ $item->nome_disciplina }}</div>
                                </td>
                                <td style="font-family: 'Courier New', monospace;">{{ $item->codigo_turma }}</td>
                                <td style="font-family: 'Courier New', monospace; font-weight: 600;">{{ $item->matricula_aluno }}</td>
                                <td>{{ $item->nome_aluno }}</td>
                                <td>
                                    <span class="badge badge-{{ $item->status_aprovacao == 'Aprovado' ? 'success' : ($item->status_aprovacao == 'Cursando' ? 'info' : ($item->status_aprovacao == 'Recuperação' ? 'warning' : 'danger')) }}">
                                        {{ $item->status_aprovacao }}
                                    </span>
                                </td>
                                <td>
                                    <button onclick="verDetalhesAluno('{{ $item->matricula_aluno }}', '{{ $item->nome_aluno }}')" 
                                            class="btn btn-outline" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">
                                        👁️ Detalhes
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Resumo por Disciplina -->
            <div style="margin-top: 2rem;">
                <h3 style="margin-bottom: 1rem;">📊 Resumo por Disciplina</h3>
                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Disciplina</th>
                                <th>Total de Alunos</th>
                                <th>Cursando</th>
                                <th>Aprovados</th>
                                <th>Reprovados</th>
                                <th>Taxa de Aprovação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($relatorio->groupBy('nome_disciplina') as $disciplina => $alunos)
                                @php
                                    $total = $alunos->count();
                                    $cursando = $alunos->where('status_aprovacao', 'Cursando')->count();
                                    $aprovados = $alunos->where('status_aprovacao', 'Aprovado')->count();
                                    $reprovados = $alunos->where('status_aprovacao', 'Reprovado')->count();
                                    $concluidos = $aprovados + $reprovados;
                                    $taxaAprovacao = $concluidos > 0 ? ($aprovados / $concluidos) * 100 : 0;
                                @endphp
                                <tr>
                                    <td style="font-weight: 600;">{{ $disciplina }}</td>
                                    <td>{{ $total }}</td>
                                    <td><span class="badge badge-info">{{ $cursando }}</span></td>
                                    <td><span class="badge badge-success">{{ $aprovados }}</span></td>
                                    <td><span class="badge badge-danger">{{ $reprovados }}</span></td>
                                    <td>
                                        <div style="color: {{ $taxaAprovacao >= 70 ? 'var(--success-color)' : ($taxaAprovacao >= 50 ? 'var(--warning-color)' : 'var(--danger-color)') }}; font-weight: 600;">
                                            {{ number_format($taxaAprovacao, 1) }}%
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        @else
            <div style="text-align: center; padding: 3rem; color: var(--secondary-color);">
                <div style="font-size: 4rem; margin-bottom: 1rem;">📋</div>
                <h3>Nenhum dado encontrado</h3>
                <p>Não há matrículas registradas para gerar o relatório.</p>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function filtrarTabela() {
    const filtroDisciplina = document.getElementById('filtroDisciplina').value.toLowerCase();
    const filtroStatus = document.getElementById('filtroStatus').value.toLowerCase();
    const buscarAluno = document.getElementById('buscarAluno').value.toLowerCase();
    const tabela = document.getElementById('tabelaRelatorio');
    const linhas = tabela.getElementsByTagName('tr');

    for (let i = 1; i < linhas.length; i++) {
        const linha = linhas[i];
        const disciplina = linha.cells[0].textContent.toLowerCase();
        const aluno = linha.cells[3].textContent.toLowerCase();
        const status = linha.cells[4].textContent.toLowerCase();

        const mostrarLinha = 
            (filtroDisciplina === '' || disciplina.includes(filtroDisciplina)) &&
            (filtroStatus === '' || status.includes(filtroStatus)) &&
            (buscarAluno === '' || aluno.includes(buscarAluno));

        linha.style.display = mostrarLinha ? '' : 'none';
    }
}

function verDetalhesAluno(matricula, nome) {
    alert(`Detalhes do Aluno:\n\nNome: ${nome}\nMatrícula: ${matricula}\n\nEsta funcionalidade será expandida para mostrar mais detalhes do histórico acadêmico do aluno.`);
}

// Função para exportar dados
function exportarDados(formato) {
    if (formato === 'pdf') {
        alert('Exportação para PDF será implementada.');
    } else if (formato === 'excel') {
        alert('Exportação para Excel será implementada.');
    }
}
</script>
@endpush
@endsection
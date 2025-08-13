@extends('layouts.app')

@section('title', 'Relatórios e Análises')

@section('content')
<div class="card">
    <div class="card-header">
        <h1 class="card-title">📊 Relatórios e Análises</h1>
        <div style="color: var(--secondary-color); font-size: 0.875rem; margin-top: 0.25rem;">
            Centro de relatórios gerenciais da instituição
        </div>
    </div>
    <div class="card-body">
        <div class="grid grid-3">
            <!-- Relatórios Acadêmicos -->
            <div class="card" style="border: 1px solid var(--primary-color);">
                <div class="card-header" style="background: var(--primary-color); color: var(--white);">
                    <h3 style="margin: 0; font-size: 1rem;">📚 Relatórios Acadêmicos</h3>
                </div>
                <div class="card-body" style="padding: 0;">
                    <nav class="sidebar-nav">
                        <li><a href="{{ route('admin.relatorio-alunos-turma') }}">📋 Alunos por Turma</a></li>
                        <li><a href="#" onclick="gerarRelatorio('aprovacao-reprovacao')">📈 Aprovações/Reprovações</a></li>
                        <li><a href="#" onclick="gerarRelatorio('historico-notas')">📊 Histórico de Notas</a></li>
                        <li><a href="#" onclick="gerarRelatorio('frequencia')">⏰ Relatório de Frequência</a></li>
                        <li><a href="#" onclick="gerarRelatorio('pre-requisitos')">🔗 Disciplinas e Pré-requisitos</a></li>
                    </nav>
                </div>
            </div>

            <!-- Relatórios Administrativos -->
            <div class="card" style="border: 1px solid var(--success-color);">
                <div class="card-header" style="background: var(--success-color); color: var(--white);">
                    <h3 style="margin: 0; font-size: 1rem;">🏛️ Relatórios Administrativos</h3>
                </div>
                <div class="card-body" style="padding: 0;">
                    <nav class="sidebar-nav">
                        <li><a href="#" onclick="gerarRelatorio('professores-carga')">👨‍🏫 Carga Horária Professores</a></li>
                        <li><a href="#" onclick="gerarRelatorio('cursos-departamentos')">🎓 Cursos por Departamento</a></li>
                        <li><a href="#" onclick="gerarRelatorio('salas-ocupacao')">🏫 Ocupação de Salas</a></li>
                        <li><a href="#" onclick="gerarRelatorio('alunos-status')">📊 Status dos Alunos</a></li>
                        <li><a href="#" onclick="gerarRelatorio('evasao')">📉 Taxa de Evasão</a></li>
                    </nav>
                </div>
            </div>

            <!-- Relatórios Estatísticos -->
            <div class="card" style="border: 1px solid var(--info-color);">
                <div class="card-header" style="background: var(--info-color); color: var(--white);">
                    <h3 style="margin: 0; font-size: 1rem;">📈 Relatórios Estatísticos</h3>
                </div>
                <div class="card-body" style="padding: 0;">
                    <nav class="sidebar-nav">
                        <li><a href="#" onclick="gerarRelatorio('media-curso')">🎯 Média por Curso</a></li>
                        <li><a href="#" onclick="gerarRelatorio('ranking-disciplinas')">🏆 Ranking de Disciplinas</a></li>
                        <li><a href="#" onclick="gerarRelatorio('desempenho-professor')">👨‍🏫 Desempenho por Professor</a></li>
                        <li><a href="#" onclick="gerarRelatorio('matriculas-semestre')">📅 Matrículas por Semestre</a></li>
                        <li><a href="#" onclick="gerarRelatorio('crescimento')">📊 Crescimento da Instituição</a></li>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Área de Resultados -->
<div id="areaResultados" class="card" style="margin-top: 2rem; display: none;">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="card-title" id="tituloRelatorio">Resultado do Relatório</h2>
            <div>
                <button onclick="exportarPDF()" class="btn btn-danger">📄 Exportar PDF</button>
                <button onclick="exportarExcel()" class="btn btn-success">📊 Exportar Excel</button>
            </div>
        </div>
    </div>
    <div class="card-body" id="conteudoRelatorio">
        <!-- Conteúdo será inserido via JavaScript -->
    </div>
</div>

<!-- Painel de Estatísticas Rápidas -->
<div class="card" style="margin-top: 2rem;">
    <div class="card-header">
        <h2 class="card-title">📊 Estatísticas Gerais da Instituição</h2>
    </div>
    <div class="card-body">
        <div class="grid grid-4">
            <div style="text-align: center; padding: 1rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: var(--border-radius);">
                <div style="font-size: 2rem; font-weight: bold;">{{ \App\Models\Aluno::count() }}</div>
                <div>Total de Alunos</div>
            </div>
            
            <div style="text-align: center; padding: 1rem; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border-radius: var(--border-radius);">
                <div style="font-size: 2rem; font-weight: bold;">{{ \App\Models\Professor::count() }}</div>
                <div>Total de Professores</div>
            </div>
            
            <div style="text-align: center; padding: 1rem; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; border-radius: var(--border-radius);">
                <div style="font-size: 2rem; font-weight: bold;">{{ \App\Models\Curso::count() }}</div>
                <div>Total de Cursos</div>
            </div>
            
            <div style="text-align: center; padding: 1rem; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; border-radius: var(--border-radius);">
                <div style="font-size: 2rem; font-weight: bold;">{{ \App\Models\Turma::where('semestre_letivo', '2025.1')->count() }}</div>
                <div>Turmas Ativas</div>
            </div>
        </div>
    </div>
</div>

<!-- Gráficos de Performance -->
<div class="grid grid-2" style="margin-top: 2rem;">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">📈 Aprovações vs Reprovações</h3>
        </div>
        <div class="card-body">
            <canvas id="graficoAprovacao" width="400" height="200"></canvas>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">👥 Alunos por Curso</h3>
        </div>
        <div class="card-body">
            <canvas id="graficoAlunosCurso" width="400" height="200"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function gerarRelatorio(tipo) {
    const area = document.getElementById('areaResultados');
    const titulo = document.getElementById('tituloRelatorio');
    const conteudo = document.getElementById('conteudoRelatorio');
    
    area.style.display = 'block';
    
    switch(tipo) {
        case 'aprovacao-reprovacao':
            titulo.textContent = '📈 Relatório de Aprovações e Reprovações';
            conteudo.innerHTML = `
                <div style="text-align: center; padding: 2rem;">
                    <div class="spinner"></div>
                    <p>Gerando relatório...</p>
                </div>
            `;
            
            setTimeout(() => {
                conteudo.innerHTML = `
                    <div class="grid grid-3">
                        <div style="text-align: center; padding: 1rem; background: var(--success-color); color: white; border-radius: var(--border-radius);">
                            <div style="font-size: 2rem; font-weight: bold;">68%</div>
                            <div>Taxa de Aprovação</div>
                        </div>
                        <div style="text-align: center; padding: 1rem; background: var(--danger-color); color: white; border-radius: var(--border-radius);">
                            <div style="font-size: 2rem; font-weight: bold;">22%</div>
                            <div>Taxa de Reprovação</div>
                        </div>
                        <div style="text-align: center; padding: 1rem; background: var(--warning-color); color: white; border-radius: var(--border-radius);">
                            <div style="font-size: 2rem; font-weight: bold;">10%</div>
                            <div>Em Recuperação</div>
                        </div>
                    </div>
                    <table class="table" style="margin-top: 2rem;">
                        <thead>
                            <tr><th>Curso</th><th>Aprovados</th><th>Reprovados</th><th>Taxa de Aprovação</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>Ciência da Computação</td><td>45</td><td>12</td><td>78.9%</td></tr>
                            <tr><td>Engenharia de Software</td><td>38</td><td>15</td><td>71.7%</td></tr>
                            <tr><td>Engenharia Civil</td><td>52</td><td>8</td><td>86.7%</td></tr>
                            <tr><td>Administração</td><td>41</td><td>19</td><td>68.3%</td></tr>
                        </tbody>
                    </table>
                `;
            }, 1500);
            break;
            
        case 'professores-carga':
            titulo.textContent = '👨‍🏫 Relatório de Carga Horária dos Professores';
            conteudo.innerHTML = `
                <div style="text-align: center; padding: 2rem;">
                    <div class="spinner"></div>
                    <p>Carregando dados dos professores...</p>
                </div>
            `;
            
            setTimeout(() => {
                conteudo.innerHTML = `
                    <table class="table">
                        <thead>
                            <tr><th>Professor</th><th>Departamento</th><th>Carga Horária</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>Prof. João Silva</td><td>Computação</td><td>18h/semana</td><td><span class="badge badge-warning">Alto</span></td></tr>
                            <tr><td>Prof. Maria Santos</td><td>Computação</td><td>12h/semana</td><td><span class="badge badge-success">Normal</span></td></tr>
                            <tr><td>Prof. Carlos Oliveira</td><td>Engenharias</td><td>20h/semana</td><td><span class="badge badge-danger">Máximo</span></td></tr>
                            <tr><td>Prof. Ana Costa</td><td>Ciências Humanas</td><td>16h/semana</td><td><span class="badge badge-info">Médio</span></td></tr>
                        </tbody>
                    </table>
                `;
            }, 1200);
            break;
            
        default:
            titulo.textContent = '📊 Relatório em Desenvolvimento';
            conteudo.innerHTML = `
                <div style="text-align: center; padding: 3rem; color: var(--secondary-color);">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">🚧</div>
                    <h3>Relatório em Desenvolvimento</h3>
                    <p>Este relatório está sendo implementado e estará disponível em breve.</p>
                </div>
            `;
    }
}

function exportarPDF() {
    alert('Funcionalidade de exportação para PDF será implementada.');
}

function exportarExcel() {
    alert('Funcionalidade de exportação para Excel será implementada.');
}

// Gráfico de Aprovações
const ctxAprovacao = document.getElementById('graficoAprovacao').getContext('2d');
new Chart(ctxAprovacao, {
    type: 'doughnut',
    data: {
        labels: ['Aprovados', 'Reprovados', 'Em Recuperação'],
        datasets: [{
            data: [68, 22, 10],
            backgroundColor: ['#28a745', '#dc3545', '#ffc107']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Gráfico de Alunos por Curso
const ctxCurso = document.getElementById('graficoAlunosCurso').getContext('2d');
new Chart(ctxCurso, {
    type: 'bar',
    data: {
        labels: ['Ciência da Computação', 'Eng. Software', 'Eng. Civil', 'Administração'],
        datasets: [{
            label: 'Número de Alunos',
            data: [57, 53, 60, 60],
            backgroundColor: ['#007bff', '#17a2b8', '#28a745', '#ffc107']
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script>
@endpush
@endsection
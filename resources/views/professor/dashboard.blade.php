@extends('layouts.app')

@section('title', 'Painel do Professor')

@section('content')
<div class="grid grid-4">
    <!-- Stats Cards -->
    <div class="card">
        <div class="card-body" style="text-align: center;">
            <div style="font-size: 2rem; color: var(--primary-color); margin-bottom: 0.5rem;">👨‍🏫</div>
            <div style="font-size: 1.5rem; font-weight: 600; color: var(--primary-color);">{{ $turmas->count() }}</div>
            <div style="color: var(--secondary-color); font-size: 0.875rem;">Turmas Ativas</div>
        </div>
    </div>

    <div class="card">
        <div class="card-body" style="text-align: center;">
            <div style="font-size: 2rem; color: var(--success-color); margin-bottom: 0.5rem;">👥</div>
            <div style="font-size: 1.5rem; font-weight: 600; color: var(--success-color);">
                {{ $turmas->sum(function($turma) { return $turma->matriculas->count(); }) }}
            </div>
            <div style="color: var(--secondary-color); font-size: 0.875rem;">Total de Alunos</div>
        </div>
    </div>

    <div class="card">
        <div class="card-body" style="text-align: center;">
            <div style="font-size: 2rem; color: var(--info-color); margin-bottom: 0.5rem;">📊</div>
            <div style="font-size: 1.5rem; font-weight: 600; color: var(--info-color);">{{ $professor->carga_horaria_semanal }}</div>
            <div style="color: var(--secondary-color); font-size: 0.875rem;">Horas/Semana</div>
        </div>
    </div>

    <div class="card">
        <div class="card-body" style="text-align: center;">
            <div style="font-size: 2rem; color: var(--warning-color); margin-bottom: 0.5rem;">📝</div>
            <div style="font-size: 1.5rem; font-weight: 600; color: var(--warning-color);">
                {{ $turmas->sum(function($turma) { return $turma->matriculas->where('status_aprovacao', 'Cursando')->count(); }) }}
            </div>
            <div style="color: var(--secondary-color); font-size: 0.875rem;">Pendentes Avaliação</div>
        </div>
    </div>
</div>

<div class="card" style="margin-top: 2rem;">
    <div class="card-header">
        <h2 class="card-title">Minhas Turmas - Semestre 2025.1</h2>
    </div>
    <div class="card-body">
        @if($turmas->count() > 0)
            <div class="grid grid-2">
                @foreach($turmas as $turma)
                    <div class="card" style="border: 1px solid #dee2e6;">
                        <div class="card-header" style="background: var(--primary-color); color: var(--white);">
                            <h3 style="margin: 0; font-size: 1rem; font-weight: 600;">
                                {{ $turma->disciplina->nome_disciplina }}
                            </h3>
                            <div style="font-size: 0.75rem; opacity: 0.9;">
                                {{ $turma->codigo_turma }} | {{ $turma->disciplina->codigo_disciplina }}
                            </div>
                        </div>
                        <div class="card-body">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                                <div>
                                    <strong>Alunos:</strong> {{ $turma->matriculas->count() }}/{{ $turma->vagas_maximas }}
                                </div>
                                <div>
                                    <strong>Créditos:</strong> {{ $turma->disciplina->creditos }}
                                </div>
                            </div>
                            
                            <div style="margin-bottom: 1rem;">
                                <div style="font-size: 0.875rem; color: var(--secondary-color);">
                                    <strong>Status da Turma:</strong>
                                    <span class="badge badge-{{ $turma->status_turma === 'Aberta' ? 'success' : 'info' }}">
                                        {{ $turma->status_turma }}
                                    </span>
                                </div>
                            </div>

                            <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                <a href="{{ route('professor.diario-classe', $turma->id_turma) }}" class="btn btn-primary">
                                    📝 Diário de Classe
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 3rem; color: var(--secondary-color);">
                <div style="font-size: 4rem; margin-bottom: 1rem;">👨‍🏫</div>
                <h3>Nenhuma turma atribuída</h3>
                <p>Você não possui turmas atribuídas para este semestre.</p>
            </div>
        @endif
    </div>
</div>

<div class="card" style="margin-top: 2rem;">
    <div class="card-header">
        <h2 class="card-title">Ações Rápidas</h2>
    </div>
    <div class="card-body">
        <div class="grid grid-3">
            <a href="#" class="card" style="text-decoration: none; color: inherit; border: 1px solid #dee2e6; transition: var(--transition);">
                <div class="card-body" style="text-align: center;">
                    <div style="font-size: 2rem; color: var(--primary-color); margin-bottom: 0.5rem;">📊</div>
                    <div style="font-weight: 600;">Relatórios de Notas</div>
                    <div style="color: var(--secondary-color); font-size: 0.875rem;">Visualizar estatísticas das turmas</div>
                </div>
            </a>

            <a href="#" class="card" style="text-decoration: none; color: inherit; border: 1px solid #dee2e6; transition: var(--transition);">
                <div class="card-body" style="text-align: center;">
                    <div style="font-size: 2rem; color: var(--success-color); margin-bottom: 0.5rem;">📅</div>
                    <div style="font-weight: 600;">Horários</div>
                    <div style="color: var(--secondary-color); font-size: 0.875rem;">Consultar horário de aulas</div>
                </div>
            </a>

            <a href="#" class="card" style="text-decoration: none; color: inherit; border: 1px solid #dee2e6; transition: var(--transition);">
                <div class="card-body" style="text-align: center;">
                    <div style="font-size: 2rem; color: var(--info-color); margin-bottom: 0.5rem;">📋</div>
                    <div style="font-weight: 600;">Listas de Presença</div>
                    <div style="color: var(--secondary-color); font-size: 0.875rem;">Gerenciar frequência dos alunos</div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Painel do Aluno')

@section('content')
<div class="grid grid-4">
    <!-- Stats Cards -->
    <div class="card">
        <div class="card-body" style="text-align: center;">
            <div style="font-size: 2rem; color: var(--primary-color); margin-bottom: 0.5rem;">📚</div>
            <div style="font-size: 1.5rem; font-weight: 600; color: var(--primary-color);">{{ $matriculas->count() }}</div>
            <div style="color: var(--secondary-color); font-size: 0.875rem;">Disciplinas Cursadas</div>
        </div>
    </div>

    <div class="card">
        <div class="card-body" style="text-align: center;">
            <div style="font-size: 2rem; color: var(--success-color); margin-bottom: 0.5rem;">✅</div>
            <div style="font-size: 1.5rem; font-weight: 600; color: var(--success-color);">
                {{ $matriculas->where('status_aprovacao', 'Aprovado')->count() }}
            </div>
            <div style="color: var(--secondary-color); font-size: 0.875rem;">Aprovações</div>
        </div>
    </div>

    <div class="card">
        <div class="card-body" style="text-align: center;">
            <div style="font-size: 2rem; color: var(--info-color); margin-bottom: 0.5rem;">📊</div>
            <div style="font-size: 1.5rem; font-weight: 600; color: var(--info-color);">
                {{ number_format($matriculas->where('nota_final', '!=', null)->avg('nota_final'), 1) ?? 'N/A' }}
            </div>
            <div style="color: var(--secondary-color); font-size: 0.875rem;">Média Geral</div>
        </div>
    </div>

    <div class="card">
        <div class="card-body" style="text-align: center;">
            <div style="font-size: 2rem; color: var(--warning-color); margin-bottom: 0.5rem;">⏰</div>
            <div style="font-size: 1.5rem; font-weight: 600; color: var(--warning-color);">{{ $proximasAvaliacoes->count() }}</div>
            <div style="color: var(--secondary-color); font-size: 0.875rem;">Próximas Avaliações</div>
        </div>
    </div>
</div>

<div class="grid grid-2" style="margin-top: 2rem;">
    <!-- Menu de Navegação -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Menu Principal</h2>
        </div>
        <div class="card-body" style="padding: 0;">
            <nav class="sidebar-nav">
                <li><a href="{{ route('aluno.boletim') }}">📋 Boletim de Notas</a></li>
                <li><a href="{{ route('aluno.horarios') }}">🕐 Horário de Aulas</a></li>
                <li><a href="{{ route('aluno.matricula-online') }}">📝 Matrícula Online</a></li>
                <li><a href="{{ route('aluno.historico') }}">📜 Histórico Escolar</a></li>
            </nav>
        </div>
    </div>

    <!-- Minhas Notas Resumo -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Minhas Notas - Resumo</h2>
        </div>
        <div class="card-body">
            @if($matriculas->count() > 0)
                <div style="max-height: 300px; overflow-y: auto;">
                    @foreach($matriculas->take(5) as $matricula)
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #f1f3f4;">
                            <div>
                                <div style="font-weight: 500;">{{ $matricula->turma->disciplina->nome_disciplina }}</div>
                                <div style="font-size: 0.75rem; color: var(--secondary-color);">{{ $matricula->turma->codigo_turma }}</div>
                            </div>
                            <div style="text-align: right;">
                                @if($matricula->nota_final)
                                    <div style="font-weight: 600; color: {{ $matricula->nota_final >= 7 ? 'var(--success-color)' : ($matricula->nota_final >= 4 ? 'var(--warning-color)' : 'var(--danger-color)') }};">
                                        {{ number_format($matricula->nota_final, 1) }}
                                    </div>
                                    <div class="badge badge-{{ $matricula->status_aprovacao == 'Aprovado' ? 'success' : ($matricula->status_aprovacao == 'Cursando' ? 'info' : 'danger') }}">
                                        {{ $matricula->status_aprovacao }}
                                    </div>
                                @else
                                    <div class="badge badge-info">Em Curso</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div style="text-align: center; margin-top: 1rem;">
                    <a href="{{ route('aluno.boletim') }}" class="btn btn-primary">Ver Boletim Completo</a>
                </div>
            @else
                <div style="text-align: center; padding: 2rem; color: var(--secondary-color);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📚</div>
                    <p>Nenhuma disciplina cursada ainda.</p>
                    <a href="{{ route('aluno.matricula-online') }}" class="btn btn-primary" style="margin-top: 1rem;">Fazer Matrícula</a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Próximas Avaliações -->
@if($proximasAvaliacoes->count() > 0)
<div class="card" style="margin-top: 2rem;">
    <div class="card-header">
        <h2 class="card-title">Próximas Avaliações</h2>
    </div>
    <div class="card-body">
        <div class="grid grid-3">
            @foreach($proximasAvaliacoes as $avaliacao)
                <div style="background: var(--light-color); padding: 1rem; border-radius: var(--border-radius);">
                    <div style="font-weight: 600; margin-bottom: 0.5rem;">{{ $avaliacao->nome_disciplina }}</div>
                    <div style="color: var(--secondary-color); font-size: 0.875rem;">{{ $avaliacao->descricao_avaliacao }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection
@extends('layouts.app')

@section('title', 'Painel Administrativo')

@section('content')
<div class="grid grid-4">
    <!-- Stats Cards -->
    <div class="card">
        <div class="card-body" style="text-align: center;">
            <div style="font-size: 2rem; color: var(--primary-color); margin-bottom: 0.5rem;">👨‍🎓</div>
            <div style="font-size: 1.5rem; font-weight: 600; color: var(--primary-color);">{{ $totalAlunos }}</div>
            <div style="color: var(--secondary-color); font-size: 0.875rem;">Total de Alunos</div>
        </div>
    </div>

    <div class="card">
        <div class="card-body" style="text-align: center;">
            <div style="font-size: 2rem; color: var(--success-color); margin-bottom: 0.5rem;">👨‍🏫</div>
            <div style="font-size: 1.5rem; font-weight: 600; color: var(--success-color);">{{ $totalProfessores }}</div>
            <div style="color: var(--secondary-color); font-size: 0.875rem;">Total de Professores</div>
        </div>
    </div>

    <div class="card">
        <div class="card-body" style="text-align: center;">
            <div style="font-size: 2rem; color: var(--info-color); margin-bottom: 0.5rem;">📚</div>
            <div style="font-size: 1.5rem; font-weight: 600; color: var(--info-color);">{{ $totalCursos }}</div>
            <div style="color: var(--secondary-color); font-size: 0.875rem;">Total de Cursos</div>
        </div>
    </div>

    <div class="card">
        <div class="card-body" style="text-align: center;">
            <div style="font-size: 2rem; color: var(--warning-color); margin-bottom: 0.5rem;">🏫</div>
            <div style="font-size: 1.5rem; font-weight: 600; color: var(--warning-color);">{{ $totalTurmas }}</div>
            <div style="color: var(--secondary-color); font-size: 0.875rem;">Turmas Ativas</div>
        </div>
    </div>
</div>

<div class="grid grid-2" style="margin-top: 2rem;">
    <!-- Menu de Gerenciamento -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Gerenciamento Acadêmico</h2>
        </div>
        <div class="card-body" style="padding: 0;">
            <nav class="sidebar-nav">
                <li><a href="{{ route('admin.alunos') }}">👨‍🎓 Gerenciar Alunos</a></li>
                <li><a href="{{ route('admin.professores') }}">👨‍🏫 Gerenciar Professores</a></li>
                <li><a href="{{ route('admin.cursos') }}">📚 Gerenciar Cursos</a></li>
                <li><a href="#">🏛️ Gerenciar Departamentos</a></li>
                <li><a href="#">📖 Gerenciar Disciplinas</a></li>
                <li><a href="#">🏫 Gerenciar Turmas</a></li>
            </nav>
        </div>
    </div>

    <!-- Menu de Relatórios -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Relatórios e Análises</h2>
        </div>
        <div class="card-body" style="padding: 0;">
            <nav class="sidebar-nav">
                <li><a href="{{ route('admin.relatorio-alunos-turma') }}">📊 Alunos por Turma</a></li>
                <li><a href="#">📈 Aprovações/Reprovações</a></li>
                <li><a href="#">📉 Taxa de Evasão</a></li>
                <li><a href="#">🎯 Relatório de Notas</a></li>
                <li><a href="#">⏰ Relatório de Frequência</a></li>
                <li><a href="#">💰 Relatório Financeiro</a></li>
            </nav>
        </div>
    </div>
</div>

<div class="card" style="margin-top: 2rem;">
    <div class="card-header">
        <h2 class="card-title">Ações Rápidas</h2>
    </div>
    <div class="card-body">
        <div class="grid grid-4">
            <button onclick="openModal('modalNovoAluno')" class="card" style="background: none; border: 2px dashed var(--primary-color); cursor: pointer;">
                <div class="card-body" style="text-align: center;">
                    <div style="font-size: 2rem; color: var(--primary-color); margin-bottom: 0.5rem;">➕</div>
                    <div style="font-weight: 600; color: var(--primary-color);">Novo Aluno</div>
                </div>
            </button>

            <button onclick="openModal('modalNovoProfessor')" class="card" style="background: none; border: 2px dashed var(--success-color); cursor: pointer;">
                <div class="card-body" style="text-align: center;">
                    <div style="font-size: 2rem; color: var(--success-color); margin-bottom: 0.5rem;">➕</div>
                    <div style="font-weight: 600; color: var(--success-color);">Novo Professor</div>
                </div>
            </button>

            <button onclick="openModal('modalNovoCurso')" class="card" style="background: none; border: 2px dashed var(--info-color); cursor: pointer;">
                <div class="card-body" style="text-align: center;">
                    <div style="font-size: 2rem; color: var(--info-color); margin-bottom: 0.5rem;">➕</div>
                    <div style="font-weight: 600; color: var(--info-color);">Novo Curso</div>
                </div>
            </button>

            <a href="{{ route('admin.relatorios') }}" class="card" style="text-decoration: none; color: inherit; border: 1px solid var(--warning-color);">
                <div class="card-body" style="text-align: center;">
                    <div style="font-size: 2rem; color: var(--warning-color); margin-bottom: 0.5rem;">📊</div>
                    <div style="font-weight: 600; color: var(--warning-color);">Ver Relatórios</div>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="card" style="margin-top: 2rem;">
    <div class="card-header">
        <h2 class="card-title">Resumo do Sistema</h2>
    </div>
    <div class="card-body">
        <div class="grid grid-3">
            <div style="text-align: center; padding: 1rem;">
                <div style="font-size: 1.25rem; font-weight: 600; color: var(--primary-color); margin-bottom: 0.5rem;">
                    Sistema Acadêmico
                </div>
                <div style="color: var(--secondary-color); font-size: 0.875rem;">
                    Plataforma completa para gestão educacional
                </div>
            </div>
            
            <div style="text-align: center; padding: 1rem;">
                <div style="font-size: 1.25rem; font-weight: 600; color: var(--success-color); margin-bottom: 0.5rem;">
                    Multi-usuário
                </div>
                <div style="color: var(--secondary-color); font-size: 0.875rem;">
                    Alunos, Professores e Administradores
                </div>
            </div>
            
            <div style="text-align: center; padding: 1rem;">
                <div style="font-size: 1.25rem; font-weight: 600; color: var(--info-color); margin-bottom: 0.5rem;">
                    Totalmente Responsivo
                </div>
                <div style="color: var(--secondary-color); font-size: 0.875rem;">
                    Funciona em todos os dispositivos
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
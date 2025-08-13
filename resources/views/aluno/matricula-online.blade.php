@extends('layouts.app')

@section('title', 'Matrícula Online')

@section('content')
<div class="card">
    <div class="card-header">
        <h1 class="card-title">📝 Matrícula Online</h1>
        <div style="color: var(--secondary-color); font-size: 0.875rem; margin-top: 0.25rem;">
            Semestre 2025.1 - Período de Matrícula Aberto
        </div>
    </div>
    <div class="card-body">
        @if($turmasDisponiveis->count() > 0)
            <div class="grid grid-2">
                @foreach($turmasDisponiveis as $turma)
                    <div class="card" style="border: 1px solid #dee2e6;">
                        <div class="card-header" style="background: var(--light-color);">
                            <h3 style="margin: 0; font-size: 1rem; font-weight: 600;">
                                {{ $turma->disciplina->nome_disciplina }}
                            </h3>
                            <div style="font-size: 0.75rem; color: var(--secondary-color); margin-top: 0.25rem;">
                                {{ $turma->disciplina->codigo_disciplina }} | {{ $turma->codigo_turma }}
                            </div>
                        </div>
                        <div class="card-body">
                            <div style="margin-bottom: 1rem;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                    <span><strong>Créditos:</strong></span>
                                    <span>{{ $turma->disciplina->creditos }}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                    <span><strong>Carga Horária:</strong></span>
                                    <span>{{ $turma->disciplina->carga_horaria }}h</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                    <span><strong>Professor:</strong></span>
                                    <span>{{ $turma->professor->pessoa->nome ?? 'A definir' }}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                    <span><strong>Vagas:</strong></span>
                                    <span>{{ $turma->vagas_disponiveis }}/{{ $turma->vagas_maximas }}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                    <span><strong>Status:</strong></span>
                                    <span class="badge badge-success">{{ $turma->status_turma }}</span>
                                </div>
                            </div>

                            @if($turma->disciplina->ementa)
                                <div style="margin-bottom: 1rem;">
                                    <strong>Ementa:</strong>
                                    <p style="font-size: 0.875rem; color: var(--secondary-color); margin: 0.5rem 0;">
                                        {{ Str::limit($turma->disciplina->ementa, 100) }}
                                    </p>
                                </div>
                            @endif

                            <div style="text-align: center;">
                                @if($turma->vagas_disponiveis > 0)
                                    <form method="POST" action="{{ route('aluno.realizar-matricula') }}" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="turma_id" value="{{ $turma->id_turma }}">
                                        <button type="submit" class="btn btn-primary" 
                                                onclick="return confirm('Confirma a matrícula na disciplina {{ $turma->disciplina->nome_disciplina }}?')">
                                            ✅ Matricular-se
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-outline" disabled>
                                        ❌ Turma Lotada
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 3rem; color: var(--secondary-color);">
                <div style="font-size: 4rem; margin-bottom: 1rem;">📚</div>
                <h3>Nenhuma turma disponível</h3>
                <p>Não há turmas abertas para matrícula no momento ou você já está matriculado em todas as turmas disponíveis.</p>
            </div>
        @endif
    </div>
</div>

<div class="card" style="margin-top: 2rem;">
    <div class="card-header">
        <h2 class="card-title">Informações da Matrícula</h2>
    </div>
    <div class="card-body">
        <div class="grid grid-2">
            <div>
                <h4>Período de Matrícula:</h4>
                <ul style="margin: 0;">
                    <li><strong>Início:</strong> 15/01/2025</li>
                    <li><strong>Término:</strong> 28/01/2025</li>
                    <li><strong>Início das Aulas:</strong> 03/02/2025</li>
                </ul>
            </div>
            <div>
                <h4>Orientações Importantes:</h4>
                <ul style="margin: 0;">
                    <li>Verifique os pré-requisitos antes de se matricular</li>
                    <li>Limite máximo de 6 disciplinas por semestre</li>
                    <li>Alterações de matrícula até 10/02/2025</li>
                    <li>Frequência mínima obrigatória: 75%</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="card" style="margin-top: 2rem;">
    <div class="card-header">
        <h2 class="card-title">Minhas Matrículas Atuais</h2>
    </div>
    <div class="card-body">
        @php
            $matriculasAtuais = auth()->user()->aluno->matriculas()
                ->with(['turma.disciplina'])
                ->whereHas('turma', function($q) {
                    $q->where('semestre_letivo', '2025.1');
                })
                ->get();
        @endphp

        @if($matriculasAtuais->count() > 0)
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Disciplina</th>
                            <th>Código</th>
                            <th>Turma</th>
                            <th>Créditos</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($matriculasAtuais as $matricula)
                            <tr>
                                <td>{{ $matricula->turma->disciplina->nome_disciplina }}</td>
                                <td>{{ $matricula->turma->disciplina->codigo_disciplina }}</td>
                                <td>{{ $matricula->turma->codigo_turma }}</td>
                                <td>{{ $matricula->turma->disciplina->creditos }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $matricula->status_aprovacao }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 1rem; text-align: center;">
                <strong>Total de Créditos: {{ $matriculasAtuais->sum(function($m) { return $m->turma->disciplina->creditos; }) }}</strong>
            </div>
        @else
            <div style="text-align: center; padding: 2rem; color: var(--secondary-color);">
                <p>Você ainda não possui matrículas para este semestre.</p>
            </div>
        @endif
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Diário de Classe')

@section('content')
<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="card-title">📝 Diário de Classe</h1>
                <div style="color: var(--secondary-color); font-size: 0.875rem; margin-top: 0.25rem;">
                    {{ $turma->disciplina->nome_disciplina }} - {{ $turma->codigo_turma }} | Semestre {{ $turma->semestre_letivo }}
                </div>
            </div>
            <div>
                <a href="{{ route('professor.dashboard') }}" class="btn btn-outline">← Voltar</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if($turma->matriculas->count() > 0)
            <form method="POST" action="{{ route('professor.salvar-notas', $turma->id_turma) }}">
                @csrf
                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Matrícula</th>
                                <th>Nome do Aluno</th>
                                <th>Nota P1</th>
                                <th>Nota P2</th>
                                <th>Trabalho</th>
                                <th>Média Final</th>
                                <th>Faltas</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($turma->matriculas as $matricula)
                                <tr>
                                    <td>{{ $matricula->aluno->matricula_aluno }}</td>
                                    <td>{{ $matricula->aluno->pessoa->nome }}</td>
                                    <td>
                                        <input 
                                            type="number" 
                                            name="notas[{{ $matricula->id_matricula }}][P1]" 
                                            class="form-control" 
                                            style="width: 80px;" 
                                            min="0" 
                                            max="10" 
                                            step="0.1"
                                            value="{{ $matricula->notas->where('descricao_avaliacao', 'P1')->first()->valor_nota ?? '' }}"
                                        >
                                    </td>
                                    <td>
                                        <input 
                                            type="number" 
                                            name="notas[{{ $matricula->id_matricula }}][P2]" 
                                            class="form-control" 
                                            style="width: 80px;" 
                                            min="0" 
                                            max="10" 
                                            step="0.1"
                                            value="{{ $matricula->notas->where('descricao_avaliacao', 'P2')->first()->valor_nota ?? '' }}"
                                        >
                                    </td>
                                    <td>
                                        <input 
                                            type="number" 
                                            name="notas[{{ $matricula->id_matricula }}][Trabalho]" 
                                            class="form-control" 
                                            style="width: 80px;" 
                                            min="0" 
                                            max="10" 
                                            step="0.1"
                                            value="{{ $matricula->notas->where('descricao_avaliacao', 'Trabalho')->first()->valor_nota ?? '' }}"
                                        >
                                    </td>
                                    <td>
                                        @if($matricula->nota_final)
                                            <span style="font-weight: 600; color: {{ $matricula->nota_final >= 7 ? 'var(--success-color)' : ($matricula->nota_final >= 4 ? 'var(--warning-color)' : 'var(--danger-color)') }};">
                                                {{ number_format($matricula->nota_final, 1) }}
                                            </span>
                                        @else
                                            <span style="color: var(--secondary-color);">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <input 
                                            type="number" 
                                            name="faltas[{{ $matricula->id_matricula }}]" 
                                            class="form-control" 
                                            style="width: 60px;" 
                                            min="0" 
                                            max="100"
                                            value="{{ $matricula->frequencias->where('presente', false)->count() }}"
                                        >
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $matricula->status_aprovacao == 'Aprovado' ? 'success' : ($matricula->status_aprovacao == 'Cursando' ? 'info' : 'danger') }}">
                                            {{ $matricula->status_aprovacao }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 2rem; display: flex; gap: 1rem; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary">
                        💾 Salvar Notas
                    </button>
                    <a href="{{ route('professor.calcular-media-final', $turma->id_turma) }}" 
                       class="btn btn-success"
                       onclick="return confirm('Tem certeza que deseja calcular as médias finais? Esta ação não pode ser desfeita.')">
                        🧮 Calcular Média Final
                    </a>
                </div>
            </form>
        @else
            <div style="text-align: center; padding: 3rem; color: var(--secondary-color);">
                <div style="font-size: 4rem; margin-bottom: 1rem;">👥</div>
                <h3>Nenhum aluno matriculado</h3>
                <p>Esta turma ainda não possui alunos matriculados.</p>
            </div>
        @endif
    </div>
</div>

<div class="card" style="margin-top: 2rem;">
    <div class="card-header">
        <h2 class="card-title">Informações da Disciplina</h2>
    </div>
    <div class="card-body">
        <div class="grid grid-2">
            <div>
                <p><strong>Disciplina:</strong> {{ $turma->disciplina->nome_disciplina }}</p>
                <p><strong>Código:</strong> {{ $turma->disciplina->codigo_disciplina }}</p>
                <p><strong>Créditos:</strong> {{ $turma->disciplina->creditos }}</p>
                <p><strong>Carga Horária:</strong> {{ $turma->disciplina->carga_horaria }}h</p>
            </div>
            <div>
                <p><strong>Turma:</strong> {{ $turma->codigo_turma }}</p>
                <p><strong>Semestre:</strong> {{ $turma->semestre_letivo }}</p>
                <p><strong>Vagas:</strong> {{ $turma->matriculas->count() }}/{{ $turma->vagas_maximas }}</p>
                <p><strong>Status:</strong> 
                    <span class="badge badge-{{ $turma->status_turma === 'Aberta' ? 'success' : 'info' }}">
                        {{ $turma->status_turma }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="card" style="margin-top: 2rem;">
    <div class="card-header">
        <h2 class="card-title">Instruções</h2>
    </div>
    <div class="card-body">
        <div class="grid grid-2">
            <div>
                <h4>Critérios de Avaliação:</h4>
                <ul>
                    <li><strong>Nota mínima para aprovação:</strong> 7.0</li>
                    <li><strong>Recuperação:</strong> notas entre 4.0 e 6.9</li>
                    <li><strong>Reprovação direta:</strong> nota inferior a 4.0</li>
                    <li><strong>Frequência mínima:</strong> 75% das aulas</li>
                </ul>
            </div>
            <div>
                <h4>Como usar:</h4>
                <ol>
                    <li>Insira as notas nos campos correspondentes</li>
                    <li>Registre o número de faltas de cada aluno</li>
                    <li>Clique em "Salvar Notas" para registrar as alterações</li>
                    <li>Use "Calcular Média Final" ao final do semestre</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
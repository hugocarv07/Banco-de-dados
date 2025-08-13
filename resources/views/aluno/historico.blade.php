@extends('layouts.app')

@section('title', 'Histórico Escolar')

@section('content')
<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: between; align-items: center;">
            <div>
                <h1 class="card-title">📜 Histórico Escolar</h1>
                <div style="color: var(--secondary-color); font-size: 0.875rem; margin-top: 0.25rem;">
                    Registro completo das disciplinas cursadas
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if($historico->count() > 0)
            <!-- Resumo Acadêmico -->
            <div class="grid grid-4" style="margin-bottom: 2rem;">
                <div class="card" style="border: 1px solid var(--success-color);">
                    <div class="card-body" style="text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: 600; color: var(--success-color);">
                            {{ $historico->where('status_aprovacao', 'Aprovado')->count() }}
                        </div>
                        <div style="color: var(--secondary-color); font-size: 0.875rem;">Disciplinas Aprovadas</div>
                    </div>
                </div>

                <div class="card" style="border: 1px solid var(--danger-color);">
                    <div class="card-body" style="text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: 600; color: var(--danger-color);">
                            {{ $historico->where('status_aprovacao', 'Reprovado')->count() }}
                        </div>
                        <div style="color: var(--secondary-color); font-size: 0.875rem;">Disciplinas Reprovadas</div>
                    </div>
                </div>

                <div class="card" style="border: 1px solid var(--primary-color);">
                    <div class="card-body" style="text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: 600; color: var(--primary-color);">
                            {{ $historico->sum('creditos') }}
                        </div>
                        <div style="color: var(--secondary-color); font-size: 0.875rem;">Total de Créditos</div>
                    </div>
                </div>

                <div class="card" style="border: 1px solid var(--info-color);">
                    <div class="card-body" style="text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: 600; color: var(--info-color);">
                            {{ number_format($historico->where('status_aprovacao', 'Aprovado')->avg('nota_final'), 1) ?? '0.0' }}
                        </div>
                        <div style="color: var(--secondary-color); font-size: 0.875rem;">Média Geral</div>
                    </div>
                </div>
            </div>

            <!-- Histórico por Semestre -->
            @php
                $historicoAgrupado = $historico->groupBy('semestre_letivo')->sortKeys();
            @endphp

            @foreach($historicoAgrupado as $semestre => $disciplinas)
                <div class="card" style="margin-bottom: 1.5rem; border-left: 4px solid var(--primary-color);">
                    <div class="card-header" style="background: var(--light-color);">
                        <h3 style="margin: 0; font-size: 1.125rem;">Semestre {{ $semestre }}</h3>
                        <div style="font-size: 0.875rem; color: var(--secondary-color);">
                            {{ $disciplinas->count() }} disciplinas | 
                            {{ $disciplinas->sum('creditos') }} créditos |
                            Média: {{ number_format($disciplinas->where('status_aprovacao', 'Aprovado')->avg('nota_final'), 1) ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="card-body" style="padding: 0;">
                        <table class="table" style="margin: 0;">
                            <thead style="background: var(--light-color);">
                                <tr>
                                    <th>Código</th>
                                    <th>Disciplina</th>
                                    <th>Créditos</th>
                                    <th>Nota Final</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($disciplinas as $item)
                                    <tr>
                                        <td style="font-family: 'Courier New', monospace;">{{ $item->codigo_disciplina }}</td>
                                        <td>{{ $item->disciplina_nome }}</td>
                                        <td>{{ $item->creditos }}</td>
                                        <td>
                                            <span style="font-weight: 600; color: {{ $item->nota_final >= 7 ? 'var(--success-color)' : ($item->nota_final >= 4 ? 'var(--warning-color)' : 'var(--danger-color)') }};">
                                                {{ number_format($item->nota_final, 1) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $item->status_aprovacao == 'Aprovado' ? 'success' : 'danger' }}">
                                                {{ $item->status_aprovacao }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach

        @else
            <div style="text-align: center; padding: 3rem; color: var(--secondary-color);">
                <div style="font-size: 4rem; margin-bottom: 1rem;">📜</div>
                <h3>Histórico ainda não disponível</h3>
                <p>Seu histórico escolar será gerado automaticamente após a conclusão das primeiras disciplinas.</p>
                <a href="{{ route('aluno.matricula-online') }}" class="btn btn-primary" style="margin-top: 1rem;">
                    Fazer Primeira Matrícula
                </a>
            </div>
        @endif
    </div>
</div>

@if($historico->count() > 0)
<div class="card" style="margin-top: 2rem;">
    <div class="card-header">
        <h2 class="card-title">Informações do Curso</h2>
    </div>
    <div class="card-body">
        @php
            $aluno = auth()->user()->aluno;
        @endphp
        <div class="grid grid-2">
            <div>
                <p><strong>Aluno:</strong> {{ $aluno->pessoa->nome }}</p>
                <p><strong>Matrícula:</strong> {{ $aluno->matricula_aluno }}</p>
                <p><strong>Curso:</strong> {{ $aluno->curso->nome_curso ?? 'N/A' }}</p>
                <p><strong>Status:</strong> 
                    <span class="badge badge-{{ $aluno->status_aluno == 'Ativo' ? 'success' : 'warning' }}">
                        {{ $aluno->status_aluno }}
                    </span>
                </p>
            </div>
            <div>
                <p><strong>Período de Ingresso:</strong> {{ $historico->min('semestre_letivo') ?? 'N/A' }}</p>
                <p><strong>Disciplinas Cursadas:</strong> {{ $historico->count() }}</p>
                <p><strong>Créditos Cumpridos:</strong> {{ $historico->where('status_aprovacao', 'Aprovado')->sum('creditos') }}</p>
                <p><strong>Taxa de Aprovação:</strong> 
                    @if($historico->count() > 0)
                        {{ number_format(($historico->where('status_aprovacao', 'Aprovado')->count() / $historico->count()) * 100, 1) }}%
                    @else
                        N/A
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
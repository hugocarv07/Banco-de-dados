@extends('layouts.app')

@section('title', 'Boletim de Notas')

@section('content')
<div class="card">
    <div class="card-header">
        <h1 class="card-title">📋 Boletim de Notas</h1>
    </div>
    <div class="card-body">
        @if(isset($boletim) && $boletim->count() > 0)
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Disciplina</th>
                            <th>Código</th>
                            <th>Semestre</th>
                            <th>Nota P1</th>
                            <th>Nota P2</th>
                            <th>Trabalho</th>
                            <th>Média Final</th>
                            <th>Frequência</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($boletim as $item)
                            <tr>
                                <td>{{ $item->nome_disciplina ?? 'N/A' }}</td>
                                <td>{{ $item->codigo_disciplina ?? 'N/A' }}</td>
                                <td>{{ $item->semestre_letivo ?? 'N/A' }}</td>
                                <td>{{ $item->nota_p1 ? number_format($item->nota_p1, 1) : '-' }}</td>
                                <td>{{ $item->nota_p2 ? number_format($item->nota_p2, 1) : '-' }}</td>
                                <td>{{ $item->nota_trabalho ? number_format($item->nota_trabalho, 1) : '-' }}</td>
                                <td>
                                    @if($item->nota_final)
                                        <span style="font-weight: 600; color: {{ $item->nota_final >= 7 ? 'var(--success-color)' : ($item->nota_final >= 4 ? 'var(--warning-color)' : 'var(--danger-color)') }};">
                                            {{ number_format($item->nota_final, 1) }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $item->frequencia_percentual ? number_format($item->frequencia_percentual, 1) . '%' : '-' }}</td>
                                <td>
                                    <span class="badge badge-{{ $item->status_aprovacao == 'Aprovado' ? 'success' : ($item->status_aprovacao == 'Cursando' ? 'info' : 'danger') }}">
                                        {{ $item->status_aprovacao ?? 'Cursando' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 3rem; color: var(--secondary-color);">
                <div style="font-size: 4rem; margin-bottom: 1rem;">📚</div>
                <h3>Nenhuma nota encontrada</h3>
                <p>Você ainda não possui notas lançadas ou não está matriculado em nenhuma disciplina.</p>
                <a href="{{ route('aluno.matricula-online') }}" class="btn btn-primary" style="margin-top: 1rem;">
                    Fazer Matrícula Online
                </a>
            </div>
        @endif
    </div>
</div>

<div class="card" style="margin-top: 2rem;">
    <div class="card-header">
        <h2 class="card-title">Legenda</h2>
    </div>
    <div class="card-body">
        <div class="grid grid-2">
            <div>
                <h4>Status de Aprovação:</h4>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 0.5rem;"><span class="badge badge-success">Aprovado</span> - Nota final ≥ 7.0 e frequência ≥ 75%</li>
                    <li style="margin-bottom: 0.5rem;"><span class="badge badge-warning">Recuperação</span> - Nota final entre 4.0 e 6.9</li>
                    <li style="margin-bottom: 0.5rem;"><span class="badge badge-danger">Reprovado</span> - Nota final < 4.0 ou frequência < 75%</li>
                    <li style="margin-bottom: 0.5rem;"><span class="badge badge-info">Cursando</span> - Disciplina em andamento</li>
                </ul>
            </div>
            <div>
                <h4>Critérios de Aprovação:</h4>
                <ul style="margin: 0;">
                    <li>Nota final mínima: <strong>7.0</strong></li>
                    <li>Frequência mínima: <strong>75%</strong></li>
                    <li>Recuperação: notas entre <strong>4.0 e 6.9</strong></li>
                    <li>Reprovação direta: nota < <strong>4.0</strong></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
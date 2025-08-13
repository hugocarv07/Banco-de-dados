@extends('layouts.app')

@section('title', 'Horário de Aulas')

@section('content')
<div class="card">
    <div class="card-header">
        <h1 class="card-title">🕐 Horário de Aulas</h1>
        <div style="color: var(--secondary-color); font-size: 0.875rem; margin-top: 0.25rem;">
            Semestre 2025.1
        </div>
    </div>
    <div class="card-body">
        @if($horarios->count() > 0)
            <div style="overflow-x: auto;">
                <table class="table" style="min-width: 800px;">
                    <thead>
                        <tr>
                            <th>Disciplina</th>
                            <th>Dia da Semana</th>
                            <th>Horário</th>
                            <th>Sala</th>
                            <th>Local</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($horarios as $horario)
                            <tr>
                                <td>
                                    <div style="font-weight: 600;">{{ $horario->nome_disciplina }}</div>
                                </td>
                                <td>
                                    <span class="badge badge-primary">{{ $horario->dia_semana }}</span>
                                </td>
                                <td>
                                    {{ date('H:i', strtotime($horario->hora_inicio)) }} - {{ date('H:i', strtotime($horario->hora_fim)) }}
                                </td>
                                <td>{{ $horario->numero_sala ?? 'N/A' }}</td>
                                <td>{{ $horario->bloco ? 'Bloco ' . $horario->bloco : 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Grade Semanal Visual -->
            <div style="margin-top: 2rem;">
                <h3 style="margin-bottom: 1rem;">Grade Semanal</h3>
                <div style="display: grid; grid-template-columns: 100px repeat(6, 1fr); gap: 0.5rem; font-size: 0.875rem;">
                    <!-- Header -->
                    <div style="background: var(--primary-color); color: var(--white); padding: 0.5rem; text-align: center; font-weight: 600;">Horário</div>
                    <div style="background: var(--primary-color); color: var(--white); padding: 0.5rem; text-align: center; font-weight: 600;">Segunda</div>
                    <div style="background: var(--primary-color); color: var(--white); padding: 0.5rem; text-align: center; font-weight: 600;">Terça</div>
                    <div style="background: var(--primary-color); color: var(--white); padding: 0.5rem; text-align: center; font-weight: 600;">Quarta</div>
                    <div style="background: var(--primary-color); color: var(--white); padding: 0.5rem; text-align: center; font-weight: 600;">Quinta</div>
                    <div style="background: var(--primary-color); color: var(--white); padding: 0.5rem; text-align: center; font-weight: 600;">Sexta</div>
                    <div style="background: var(--primary-color); color: var(--white); padding: 0.5rem; text-align: center; font-weight: 600;">Sábado</div>

                    @php
                        $horarios_fixos = ['08:00-10:00', '10:00-12:00', '14:00-16:00', '16:00-18:00', '19:00-21:00'];
                        $dias = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
                        $grade = [];
                        
                        foreach($horarios as $h) {
                            $hora_key = date('H:i', strtotime($h->hora_inicio)) . '-' . date('H:i', strtotime($h->hora_fim));
                            $grade[$hora_key][$h->dia_semana] = $h->nome_disciplina;
                        }
                    @endphp

                    @foreach($horarios_fixos as $hora)
                        <div style="background: var(--light-color); padding: 0.5rem; text-align: center; font-weight: 600;">{{ $hora }}</div>
                        @foreach($dias as $dia)
                            <div style="background: var(--white); border: 1px solid #dee2e6; padding: 0.5rem; text-align: center; min-height: 40px; display: flex; align-items: center; justify-content: center;">
                                @if(isset($grade[$hora][$dia]))
                                    <div style="background: var(--success-color); color: var(--white); padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem;">
                                        {{ $grade[$hora][$dia] }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        @else
            <div style="text-align: center; padding: 3rem; color: var(--secondary-color);">
                <div style="font-size: 4rem; margin-bottom: 1rem;">📅</div>
                <h3>Nenhum horário encontrado</h3>
                <p>Você ainda não possui horários de aulas para este semestre.</p>
                <a href="{{ route('aluno.matricula-online') }}" class="btn btn-primary" style="margin-top: 1rem;">
                    Fazer Matrícula Online
                </a>
            </div>
        @endif
    </div>
</div>

<div class="card" style="margin-top: 2rem;">
    <div class="card-header">
        <h2 class="card-title">Informações Importantes</h2>
    </div>
    <div class="card-body">
        <div class="grid grid-2">
            <div>
                <h4>Horários de Funcionamento:</h4>
                <ul style="margin: 0;">
                    <li><strong>Manhã:</strong> 08:00 - 12:00</li>
                    <li><strong>Tarde:</strong> 14:00 - 18:00</li>
                    <li><strong>Noite:</strong> 19:00 - 22:00</li>
                </ul>
            </div>
            <div>
                <h4>Observações:</h4>
                <ul style="margin: 0;">
                    <li>Chegue sempre 10 minutos antes do início da aula</li>
                    <li>Consulte periodicamente possíveis alterações</li>
                    <li>Frequência mínima obrigatória: 75%</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
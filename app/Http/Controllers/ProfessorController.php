<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Professor;
use App\Models\Turma;
use App\Models\Matricula;
use App\Models\Nota;
use App\Models\Frequencia;

class ProfessorController extends Controller
{
    public function dashboard()
    {
        $professor = Auth::user()->professor;
        $turmas = $professor->turmas()
            ->with(['disciplina', 'matriculas'])
            ->where('semestre_letivo', '2025.1')
            ->get();
        
        return view('professor.dashboard', compact('professor', 'turmas'));
    }

    public function diarioClasse($turmaId)
    {
        $professor = Auth::user()->professor;
        $turma = $professor->turmas()
            ->with(['disciplina', 'matriculas.aluno.pessoa'])
            ->findOrFail($turmaId);
        
        $diario = DB::table('vw_diario_professor')
            ->where('turma_id', $turmaId)
            ->get();
        
        return view('professor.diario-classe', compact('turma', 'diario'));
    }

    public function salvarNotas(Request $request, $turmaId)
    {
        $professor = Auth::user()->professor;
        $turma = $professor->turmas()->findOrFail($turmaId);
        
        $notas = $request->input('notas', []);
        
        foreach ($notas as $matriculaId => $notasData) {
            $matricula = Matricula::where('id_matricula', $matriculaId)
                ->where('id_turma', $turmaId)
                ->first();
            
            if ($matricula) {
                foreach ($notasData as $tipo => $valor) {
                    if (!empty($valor)) {
                        Nota::updateOrCreate(
                            [
                                'id_matricula' => $matriculaId,
                                'descricao_avaliacao' => $tipo
                            ],
                            [
                                'valor_nota' => $valor,
                                'peso' => $tipo === 'P1' || $tipo === 'P2' ? 1.0 : 0.5
                            ]
                        );
                    }
                }
            }
        }
        
        return back()->with('success', 'Notas salvas com sucesso!');
    }

    public function calcularMediaFinal($turmaId)
    {
        $professor = Auth::user()->professor;
        $turma = $professor->turmas()->findOrFail($turmaId);
        
        $matriculas = Matricula::where('id_turma', $turmaId)->get();
        
        foreach ($matriculas as $matricula) {
            $notasP1P2 = $matricula->notas()
                ->whereIn('descricao_avaliacao', ['P1', 'P2'])
                ->pluck('valor_nota');
            
            if ($notasP1P2->count() >= 2) {
                $media = $notasP1P2->avg();
                
                // Aplicar regras de aprovação
                if ($media >= 7.0) {
                    $status = 'Aprovado';
                } elseif ($media >= 4.0) {
                    $status = 'Recuperação';
                } else {
                    $status = 'Reprovado';
                }
                
                $matricula->update([
                    'nota_final' => $media,
                    'status_aprovacao' => $status
                ]);
            }
        }
        
        return back()->with('success', 'Médias finais calculadas com sucesso!');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Aluno;
use App\Models\Turma;
use App\Models\Matricula;

class AlunoController extends Controller
{
    public function dashboard()
    {
        $aluno = Auth::user()->aluno;
        $matriculas = $aluno->matriculas()->with(['turma.disciplina', 'notas'])->get();
        
        $proximasAvaliacoes = DB::table('notas')
            ->join('matriculas', 'notas.id_matricula', '=', 'matriculas.id_matricula')
            ->join('turmas', 'matriculas.id_turma', '=', 'turmas.id_turma')
            ->join('disciplinas', 'turmas.id_disciplina', '=', 'disciplinas.id_disciplina')
            ->where('matriculas.id_aluno', $aluno->id_aluno)
            ->whereNull('notas.valor_nota')
            ->select('disciplinas.nome_disciplina', 'notas.descricao_avaliacao')
            ->limit(3)
            ->get();

        return view('aluno.dashboard', compact('aluno', 'matriculas', 'proximasAvaliacoes'));
    }

    public function boletim()
    {
        $aluno = Auth::user()->aluno;
        $boletim = DB::table('vw_boletim_aluno')
            ->where('id_aluno', $aluno->id_aluno)
            ->get();
        
        return view('aluno.boletim', compact('boletim'));
    }

    public function historico()
    {
        $aluno = Auth::user()->aluno;
        $historico = $aluno->historicoEscolar()
            ->orderBy('semestre_letivo')
            ->get();
        
        return view('aluno.historico', compact('historico'));
    }

    public function horarios()
    {
        $aluno = Auth::user()->aluno;
        $horarios = DB::table('matriculas')
            ->join('turmas', 'matriculas.id_turma', '=', 'turmas.id_turma')
            ->join('disciplinas', 'turmas.id_disciplina', '=', 'disciplinas.id_disciplina')
            ->join('horarios', 'turmas.id_turma', '=', 'horarios.id_turma')
            ->leftJoin('salas', 'horarios.id_sala', '=', 'salas.id_sala')
            ->where('matriculas.id_aluno', $aluno->id_aluno)
            ->where('turmas.semestre_letivo', '2025.1')
            ->select(
                'disciplinas.nome_disciplina',
                'horarios.dia_semana',
                'horarios.hora_inicio',
                'horarios.hora_fim',
                'salas.numero_sala',
                'salas.bloco'
            )
            ->orderBy('horarios.dia_semana')
            ->orderBy('horarios.hora_inicio')
            ->get();
        
        return view('aluno.horarios', compact('horarios'));
    }

    public function matriculaOnline()
    {
        $aluno = Auth::user()->aluno;
        $turmasDisponiveis = Turma::with(['disciplina', 'professor.pessoa'])
            ->where('status_turma', 'Aberta')
            ->where('semestre_letivo', '2025.1')
            ->whereRaw('(SELECT COUNT(*) FROM matriculas WHERE matriculas.id_turma = turmas.id_turma) < turmas.vagas_maximas')
            ->get();
        
        return view('aluno.matricula-online', compact('turmasDisponiveis'));
    }

    public function realizarMatricula(Request $request)
    {
        $aluno = Auth::user()->aluno;
        $turmaId = $request->input('turma_id');
        
        // Verificar se já está matriculado na turma
        $matriculaExistente = Matricula::where('id_aluno', $aluno->id_aluno)
            ->where('id_turma', $turmaId)
            ->first();
        
        if ($matriculaExistente) {
            return back()->with('error', 'Você já está matriculado nesta turma.');
        }
        
        // Verificar vagas disponíveis
        $turma = Turma::findOrFail($turmaId);
        $matriculados = Matricula::where('id_turma', $turmaId)->count();
        
        if ($matriculados >= $turma->vagas_maximas) {
            return back()->with('error', 'Turma lotada. Não há vagas disponíveis.');
        }
        
        // Criar matrícula
        Matricula::create([
            'id_aluno' => $aluno->id_aluno,
            'id_turma' => $turmaId,
            'status_aprovacao' => 'Cursando'
        ]);
        
        return back()->with('success', 'Matrícula realizada com sucesso!');
    }
}
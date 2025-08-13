<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Pessoa;
use App\Models\Aluno;
use App\Models\Professor;
use App\Models\Curso;
use App\Models\Departamento;
use App\Models\Disciplina;
use App\Models\Turma;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalAlunos = Aluno::count();
        $totalProfessores = Professor::count();
        $totalCursos = Curso::count();
        $totalTurmas = Turma::where('semestre_letivo', '2025.1')->count();
        
        return view('admin.dashboard', compact(
            'totalAlunos', 
            'totalProfessores', 
            'totalCursos', 
            'totalTurmas'
        ));
    }

    public function cursos()
    {
        $cursos = Curso::with('departamento')->get();
        $departamentos = Departamento::all();
        
        return view('admin.cursos', compact('cursos', 'departamentos'));
    }

    public function storeCurso(Request $request)
    {
        $request->validate([
            'nome_curso' => 'required|string|max:100',
            'duracao_semestres' => 'required|integer|min:1|max:12',
            'id_departamento' => 'required|exists:departamentos,id_departamento'
        ]);

        Curso::create($request->all());

        return back()->with('success', 'Curso criado com sucesso!');
    }

    public function updateCurso(Request $request, $id)
    {
        $curso = Curso::findOrFail($id);
        
        $request->validate([
            'nome_curso' => 'required|string|max:100',
            'duracao_semestres' => 'required|integer|min:1|max:12',
            'id_departamento' => 'required|exists:departamentos,id_departamento'
        ]);

        $curso->update($request->all());

        return back()->with('success', 'Curso atualizado com sucesso!');
    }

    public function destroyCurso($id)
    {
        $curso = Curso::findOrFail($id);
        
        if ($curso->alunos()->count() > 0) {
            return back()->with('error', 'Não é possível excluir um curso que possui alunos matriculados.');
        }
        
        $curso->delete();

        return back()->with('success', 'Curso excluído com sucesso!');
    }

    public function alunos()
    {
        $alunos = Aluno::with(['pessoa', 'curso'])->get();
        $cursos = Curso::all();
        
        return view('admin.alunos', compact('alunos', 'cursos'));
    }

    public function storeAluno(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
            'cpf' => 'required|string|size:11|unique:pessoas,cpf',
            'email' => 'required|email|unique:pessoas,email',
            'data_nascimento' => 'required|date',
            'telefone' => 'required|string|max:15',
            'endereco' => 'required|string',
            'matricula_aluno' => 'required|string|max:20|unique:alunos,matricula_aluno',
            'id_curso' => 'required|exists:cursos,id_curso'
        ]);

        $pessoa = Pessoa::create([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'email' => $request->email,
            'data_nascimento' => $request->data_nascimento,
            'telefone' => $request->telefone,
            'endereco' => $request->endereco,
            'tipo_pessoa' => 'aluno',
            'password' => Hash::make($request->cpf) // Senha padrão é o CPF
        ]);

        Aluno::create([
            'id_pessoa' => $pessoa->id_pessoa,
            'matricula_aluno' => $request->matricula_aluno,
            'id_curso' => $request->id_curso,
            'status_aluno' => 'Ativo'
        ]);

        return back()->with('success', 'Aluno cadastrado com sucesso!');
    }

    public function professores()
    {
        $professores = Professor::with(['pessoa', 'departamento'])->get();
        $departamentos = Departamento::all();
        
        return view('admin.professores', compact('professores', 'departamentos'));
    }

    public function storeProfessor(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
            'cpf' => 'required|string|size:11|unique:pessoas,cpf',
            'email' => 'required|email|unique:pessoas,email',
            'data_nascimento' => 'required|date',
            'telefone' => 'required|string|max:15',
            'endereco' => 'required|string',
            'matricula_professor' => 'required|string|max:20|unique:professores,matricula_professor',
            'salario' => 'required|numeric|min:0',
            'titulacao' => 'required|in:Graduado,Especialista,Mestre,Doutor',
            'id_departamento' => 'required|exists:departamentos,id_departamento'
        ]);

        $pessoa = Pessoa::create([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'email' => $request->email,
            'data_nascimento' => $request->data_nascimento,
            'telefone' => $request->telefone,
            'endereco' => $request->endereco,
            'tipo_pessoa' => 'professor',
            'password' => Hash::make($request->cpf) // Senha padrão é o CPF
        ]);

        Professor::create([
            'id_pessoa' => $pessoa->id_pessoa,
            'matricula_professor' => $request->matricula_professor,
            'salario' => $request->salario,
            'titulacao' => $request->titulacao,
            'id_departamento' => $request->id_departamento
        ]);

        return back()->with('success', 'Professor cadastrado com sucesso!');
    }

    public function relatorios()
    {
        return view('admin.relatorios');
    }

    public function relatorioAlunosPorTurma()
    {
        $relatorio = \DB::table('matriculas')
            ->join('alunos', 'matriculas.id_aluno', '=', 'alunos.id_aluno')
            ->join('pessoas', 'alunos.id_pessoa', '=', 'pessoas.id_pessoa')
            ->join('turmas', 'matriculas.id_turma', '=', 'turmas.id_turma')
            ->join('disciplinas', 'turmas.id_disciplina', '=', 'disciplinas.id_disciplina')
            ->select(
                'disciplinas.nome_disciplina',
                'turmas.codigo_turma',
                'pessoas.nome as nome_aluno',
                'alunos.matricula_aluno',
                'matriculas.status_aprovacao'
            )
            ->orderBy('disciplinas.nome_disciplina')
            ->orderBy('turmas.codigo_turma')
            ->get();
        
        return view('admin.relatorios.alunos-por-turma', compact('relatorio'));
    }
}
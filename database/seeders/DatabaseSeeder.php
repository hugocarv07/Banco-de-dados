<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Pessoa;
use App\Models\Aluno;
use App\Models\Professor;
use App\Models\FuncionarioAdmin;
use App\Models\Departamento;
use App\Models\Curso;
use App\Models\Disciplina;
use App\Models\Sala;
use App\Models\Turma;
use App\Models\Horario;
use App\Models\Matricula;
use App\Models\Nota;
use App\Models\Responsavel;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Criar Departamentos
        $departamentos = [
            ['nome_departamento' => 'Departamento de Computação', 'descricao' => 'Cursos relacionados à área de tecnologia'],
            ['nome_departamento' => 'Departamento de Engenharias', 'descricao' => 'Cursos de engenharia'],
            ['nome_departamento' => 'Departamento de Ciências Humanas', 'descricao' => 'Cursos de ciências humanas']
        ];

        foreach ($departamentos as $dept) {
            Departamento::create($dept);
        }

        // Criar Cursos
        $cursos = [
            ['nome_curso' => 'Ciência da Computação', 'duracao_semestres' => 8, 'id_departamento' => 1],
            ['nome_curso' => 'Engenharia de Software', 'duracao_semestres' => 8, 'id_departamento' => 1],
            ['nome_curso' => 'Engenharia Civil', 'duracao_semestres' => 10, 'id_departamento' => 2],
            ['nome_curso' => 'Administração', 'duracao_semestres' => 8, 'id_departamento' => 3]
        ];

        foreach ($cursos as $curso) {
            Curso::create($curso);
        }

        // Criar Salas
        $salas = [
            ['numero_sala' => '101', 'bloco' => 'A', 'capacidade' => 50],
            ['numero_sala' => '102', 'bloco' => 'A', 'capacidade' => 40],
            ['numero_sala' => '201', 'bloco' => 'B', 'capacidade' => 45],
            ['numero_sala' => '301', 'bloco' => 'C', 'capacidade' => 30]
        ];

        foreach ($salas as $sala) {
            Sala::create($sala);
        }

        // Criar Disciplinas
        $disciplinas = [
            ['nome_disciplina' => 'Algoritmos e Programação I', 'codigo_disciplina' => 'PROG001', 'creditos' => 4, 'carga_horaria' => 60, 'ementa' => 'Introdução à programação', 'id_departamento' => 1],
            ['nome_disciplina' => 'Algoritmos e Programação II', 'codigo_disciplina' => 'PROG002', 'creditos' => 4, 'carga_horaria' => 60, 'ementa' => 'Programação avançada', 'id_departamento' => 1],
            ['nome_disciplina' => 'Banco de Dados I', 'codigo_disciplina' => 'BD001', 'creditos' => 4, 'carga_horaria' => 60, 'ementa' => 'Fundamentos de bancos de dados', 'id_departamento' => 1],
            ['nome_disciplina' => 'Banco de Dados II', 'codigo_disciplina' => 'BD002', 'creditos' => 4, 'carga_horaria' => 60, 'ementa' => 'Bancos de dados avançado', 'id_departamento' => 1],
            ['nome_disciplina' => 'Estrutura de Dados', 'codigo_disciplina' => 'ED001', 'creditos' => 4, 'carga_horaria' => 60, 'ementa' => 'Estruturas de dados fundamentais', 'id_departamento' => 1],
            ['nome_disciplina' => 'Sistemas Operacionais', 'codigo_disciplina' => 'SO001', 'creditos' => 4, 'carga_horaria' => 60, 'ementa' => 'Fundamentos de sistemas operacionais', 'id_departamento' => 1],
            ['nome_disciplina' => 'Cálculo I', 'codigo_disciplina' => 'CALC001', 'creditos' => 6, 'carga_horaria' => 90, 'ementa' => 'Cálculo diferencial e integral', 'id_departamento' => 2],
            ['nome_disciplina' => 'Física I', 'codigo_disciplina' => 'FIS001', 'creditos' => 4, 'carga_horaria' => 60, 'ementa' => 'Mecânica clássica', 'id_departamento' => 2],
            ['nome_disciplina' => 'Administração Geral', 'codigo_disciplina' => 'ADM001', 'creditos' => 4, 'carga_horaria' => 60, 'ementa' => 'Princípios da administração', 'id_departamento' => 3],
            ['nome_disciplina' => 'Marketing', 'codigo_disciplina' => 'MKT001', 'creditos' => 4, 'carga_horaria' => 60, 'ementa' => 'Fundamentos do marketing', 'id_departamento' => 3]
        ];

        foreach ($disciplinas as $disciplina) {
            Disciplina::create($disciplina);
        }

        // Criar Funcionário Admin
        $pessoaAdmin = Pessoa::create([
            'nome' => 'Administrador Sistema',
            'cpf' => '00000000001',
            'data_nascimento' => '1980-01-01',
            'email' => 'admin@sga.edu.br',
            'telefone' => '(11) 99999-0001',
            'endereco' => 'Rua da Administração, 123',
            'tipo_pessoa' => 'funcionario',
            'password' => Hash::make('admin123')
        ]);

        FuncionarioAdmin::create([
            'id_pessoa' => $pessoaAdmin->id_pessoa,
            'cargo' => 'Administrador do Sistema',
            'data_admissao' => '2024-01-01'
        ]);

        // Criar Professores
        $professores = [
            ['nome' => 'Prof. João Silva', 'cpf' => '11111111111', 'email' => 'joao.silva@sga.edu.br', 'matricula' => 'PROF001', 'salario' => 8000.00, 'titulacao' => 'Doutor', 'id_departamento' => 1],
            ['nome' => 'Prof. Maria Santos', 'cpf' => '22222222222', 'email' => 'maria.santos@sga.edu.br', 'matricula' => 'PROF002', 'salario' => 7500.00, 'titulacao' => 'Mestre', 'id_departamento' => 1],
            ['nome' => 'Prof. Carlos Oliveira', 'cpf' => '33333333333', 'email' => 'carlos.oliveira@sga.edu.br', 'matricula' => 'PROF003', 'salario' => 9000.00, 'titulacao' => 'Doutor', 'id_departamento' => 2],
            ['nome' => 'Prof. Ana Costa', 'cpf' => '44444444444', 'email' => 'ana.costa@sga.edu.br', 'matricula' => 'PROF004', 'salario' => 6500.00, 'titulacao' => 'Mestre', 'id_departamento' => 3],
            ['nome' => 'Prof. Pedro Lima', 'cpf' => '55555555555', 'email' => 'pedro.lima@sga.edu.br', 'matricula' => 'PROF005', 'salario' => 8500.00, 'titulacao' => 'Doutor', 'id_departamento' => 1]
        ];

        foreach ($professores as $prof) {
            $pessoa = Pessoa::create([
                'nome' => $prof['nome'],
                'cpf' => $prof['cpf'],
                'data_nascimento' => '1980-01-01',
                'email' => $prof['email'],
                'telefone' => '(11) 99999-9999',
                'endereco' => 'Endereço do Professor',
                'tipo_pessoa' => 'professor',
                'password' => Hash::make($prof['cpf'])
            ]);

            Professor::create([
                'id_pessoa' => $pessoa->id_pessoa,
                'matricula_professor' => $prof['matricula'],
                'salario' => $prof['salario'],
                'titulacao' => $prof['titulacao'],
                'id_departamento' => $prof['id_departamento'],
                'carga_horaria_semanal' => rand(8, 20)
            ]);
        }

        // Criar Alunos
        $alunos = [
            ['nome' => 'Alice Ferreira', 'cpf' => '12345678901', 'email' => 'alice@aluno.sga.edu.br', 'matricula' => '2024001', 'id_curso' => 1],
            ['nome' => 'Bruno Souza', 'cpf' => '23456789012', 'email' => 'bruno@aluno.sga.edu.br', 'matricula' => '2024002', 'id_curso' => 1],
            ['nome' => 'Carla Mendes', 'cpf' => '34567890123', 'email' => 'carla@aluno.sga.edu.br', 'matricula' => '2024003', 'id_curso' => 2],
            ['nome' => 'Daniel Pereira', 'cpf' => '45678901234', 'email' => 'daniel@aluno.sga.edu.br', 'matricula' => '2024004', 'id_curso' => 2],
            ['nome' => 'Elena Rodriguez', 'cpf' => '56789012345', 'email' => 'elena@aluno.sga.edu.br', 'matricula' => '2024005', 'id_curso' => 3],
            ['nome' => 'Fernando Alves', 'cpf' => '67890123456', 'email' => 'fernando@aluno.sga.edu.br', 'matricula' => '2024006', 'id_curso' => 3],
            ['nome' => 'Gabriela Lima', 'cpf' => '78901234567', 'email' => 'gabriela@aluno.sga.edu.br', 'matricula' => '2024007', 'id_curso' => 4],
            ['nome' => 'Henrique Silva', 'cpf' => '89012345678', 'email' => 'henrique@aluno.sga.edu.br', 'matricula' => '2024008', 'id_curso' => 4],
            ['nome' => 'Isabela Santos', 'cpf' => '90123456789', 'email' => 'isabela@aluno.sga.edu.br', 'matricula' => '2024009', 'id_curso' => 1],
            ['nome' => 'José Carlos', 'cpf' => '01234567890', 'email' => 'jose@aluno.sga.edu.br', 'matricula' => '2024010', 'id_curso' => 2]
        ];

        foreach ($alunos as $aluno) {
            $pessoa = Pessoa::create([
                'nome' => $aluno['nome'],
                'cpf' => $aluno['cpf'],
                'data_nascimento' => '2000-01-01',
                'email' => $aluno['email'],
                'telefone' => '(11) 88888-8888',
                'endereco' => 'Endereço do Aluno',
                'tipo_pessoa' => 'aluno',
                'password' => Hash::make($aluno['cpf'])
            ]);

            $alunoModel = Aluno::create([
                'id_pessoa' => $pessoa->id_pessoa,
                'matricula_aluno' => $aluno['matricula'],
                'status_aluno' => 'Ativo',
                'id_curso' => $aluno['id_curso']
            ]);

            // Criar Responsável para cada aluno
            Responsavel::create([
                'id_aluno' => $alunoModel->id_aluno,
                'nome' => 'Responsável ' . explode(' ', $aluno['nome'])[0],
                'cpf' => str_pad(rand(10000000000, 99999999999), 11, '0', STR_PAD_LEFT),
                'parentesco' => 'Pai',
                'telefone' => '(11) 77777-7777',
                'email' => 'responsavel' . $alunoModel->id_aluno . '@email.com'
            ]);
        }

        // Criar Turmas
        $turmas = [
            ['codigo_turma' => 'PROG001-A', 'id_disciplina' => 1, 'id_professor' => 1, 'semestre_letivo' => '2025.1'],
            ['codigo_turma' => 'PROG002-A', 'id_disciplina' => 2, 'id_professor' => 1, 'semestre_letivo' => '2025.1'],
            ['codigo_turma' => 'BD001-A', 'id_disciplina' => 3, 'id_professor' => 2, 'semestre_letivo' => '2025.1'],
            ['codigo_turma' => 'BD002-A', 'id_disciplina' => 4, 'id_professor' => 2, 'semestre_letivo' => '2025.1'],
            ['codigo_turma' => 'ED001-A', 'id_disciplina' => 5, 'id_professor' => 5, 'semestre_letivo' => '2025.1'],
            ['codigo_turma' => 'CALC001-A', 'id_disciplina' => 7, 'id_professor' => 3, 'semestre_letivo' => '2025.1'],
            ['codigo_turma' => 'ADM001-A', 'id_disciplina' => 9, 'id_professor' => 4, 'semestre_letivo' => '2025.1']
        ];

        foreach ($turmas as $turma) {
            $turmaModel = Turma::create([
                'codigo_turma' => $turma['codigo_turma'],
                'id_disciplina' => $turma['id_disciplina'],
                'id_professor' => $turma['id_professor'],
                'semestre_letivo' => $turma['semestre_letivo'],
                'vagas_maximas' => 50,
                'status_turma' => 'Em Andamento'
            ]);

            // Criar horários para as turmas
            Horario::create([
                'id_turma' => $turmaModel->id_turma,
                'id_sala' => rand(1, 4),
                'dia_semana' => 'Segunda',
                'hora_inicio' => '08:00:00',
                'hora_fim' => '10:00:00'
            ]);
        }

        // Criar Matrículas para os alunos
        for ($i = 1; $i <= 10; $i++) {
            // Cada aluno se matricula em 3-4 turmas
            $turmasAleatorias = collect([1, 2, 3, 4, 5, 6, 7])->random(rand(3, 4));
            
            foreach ($turmasAleatorias as $turmaId) {
                $matricula = Matricula::create([
                    'id_aluno' => $i,
                    'id_turma' => $turmaId,
                    'status_aprovacao' => 'Cursando'
                ]);

                // Adicionar algumas notas
                if (rand(0, 1)) {
                    Nota::create([
                        'id_matricula' => $matricula->id_matricula,
                        'descricao_avaliacao' => 'P1',
                        'valor_nota' => rand(40, 100) / 10,
                        'peso' => 1.0
                    ]);
                }

                if (rand(0, 1)) {
                    Nota::create([
                        'id_matricula' => $matricula->id_matricula,
                        'descricao_avaliacao' => 'P2',
                        'valor_nota' => rand(40, 100) / 10,
                        'peso' => 1.0
                    ]);
                }
            }
        }
    }
}
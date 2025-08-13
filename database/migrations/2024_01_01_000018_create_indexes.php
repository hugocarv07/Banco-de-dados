<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    // Índices para otimizar consultas frequentes do sistema

    // REMOVIDO: Este índice é redundante, pois a tabela 'matriculas'
    // já possui uma chave única para ('id_aluno', 'id_turma').
    // Schema::table('matriculas', function (Blueprint $table) {
    //     $table->index(['id_aluno', 'id_turma'], 'idx_matricula_aluno_turma');
    // });

    // Índice para acelerar relatórios de turmas por disciplina
    Schema::table('turmas', function (Blueprint $table) {
        $table->index(['id_disciplina', 'semestre_letivo'], 'idx_turma_disciplina_semestre');
    });

    // Índice para acelerar busca de notas por matrícula
    Schema::table('notas', function (Blueprint $table) {
        $table->index(['id_matricula', 'descricao_avaliacao'], 'idx_nota_matricula_tipo');
    });

    // Índice para acelerar consultas de frequência
    Schema::table('frequencias', function (Blueprint $table) {
        $table->index(['id_matricula', 'data_aula'], 'idx_frequencia_matricula_data');
    });

    // Índice para acelerar busca de horários por turma
    Schema::table('horarios', function (Blueprint $table) {
        $table->index(['id_turma', 'dia_semana'], 'idx_horario_turma_dia');
    });

    // Índice para acelerar consultas de histórico escolar
    Schema::table('historico_escolares', function (Blueprint $table) {
        $table->index(['id_aluno', 'semestre_letivo'], 'idx_historico_aluno_semestre');
    });

    // Índice para acelerar busca de turmas por professor
    Schema::table('turmas', function (Blueprint $table) {
        $table->index(['id_professor', 'semestre_letivo'], 'idx_turma_professor_semestre');
    });

    // Índice para acelerar consultas de alunos por curso
    Schema::table('alunos', function (Blueprint $table) {
        $table->index(['id_curso', 'status_aluno'], 'idx_aluno_curso_status');
    });

    // Índice para acelerar busca de disciplinas por departamento
    Schema::table('disciplinas', function (Blueprint $table) {
        $table->index(['id_departamento', 'codigo_disciplina'], 'idx_disciplina_dept_codigo');
    });

    // ERRO CORRIGIDO: Este bloco foi removido pois a tabela 'responsaveis' não tem a coluna 'id_aluno'.
    // Schema::table('responsaveis', function (Blueprint $table) {
    //     $table->index(['id_aluno', 'parentesco'], 'idx_responsavel_aluno_parentesco');
    // });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('matriculas', function (Blueprint $table) {
            $table->dropIndex('idx_matricula_aluno_turma');
        });

        Schema::table('turmas', function (Blueprint $table) {
            $table->dropIndex('idx_turma_disciplina_semestre');
            $table->dropIndex('idx_turma_professor_semestre');
        });

        Schema::table('notas', function (Blueprint $table) {
            $table->dropIndex('idx_nota_matricula_tipo');
        });

        Schema::table('frequencias', function (Blueprint $table) {
            $table->dropIndex('idx_frequencia_matricula_data');
        });

        Schema::table('horarios', function (Blueprint $table) {
            $table->dropIndex('idx_horario_turma_dia');
        });

        Schema::table('historico_escolares', function (Blueprint $table) {
            $table->dropIndex('idx_historico_aluno_semestre');
        });

        Schema::table('alunos', function (Blueprint $table) {
            $table->dropIndex('idx_aluno_curso_status');
        });

        Schema::table('disciplinas', function (Blueprint $table) {
            $table->dropIndex('idx_disciplina_dept_codigo');
        });

        Schema::table('responsaveis', function (Blueprint $table) {
            $table->dropIndex('idx_responsavel_aluno_parentesco');
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Limpa qualquer objeto antigo que possa ter sobrado de uma migration anterior
        $this->down();

        // Cria a View do Boletim do Aluno (CORRIGIDA)
        DB::statement("
            CREATE OR REPLACE VIEW vw_boletim_aluno AS
            SELECT 
                m.id_aluno,
                t.semestre_letivo,
                d.codigo_disciplina,
                d.nome_disciplina,
                MAX(CASE WHEN n.descricao_avaliacao = 'P1' THEN n.valor_nota END) as nota_p1,
                MAX(CASE WHEN n.descricao_avaliacao = 'P2' THEN n.valor_nota END) as nota_p2,
                MAX(CASE WHEN n.descricao_avaliacao = 'Trabalho' THEN n.valor_nota END) as nota_trabalho,
                m.nota_final,
                m.frequencia_percentual,
                m.status_aprovacao
            FROM matriculas m
            JOIN turmas t ON m.id_turma = t.id_turma
            JOIN disciplinas d ON t.id_disciplina = d.id_disciplina
            LEFT JOIN notas n ON m.id_matricula = n.id_matricula
            GROUP BY 
                m.id_aluno,
                t.semestre_letivo,
                d.codigo_disciplina,
                d.nome_disciplina,
                m.nota_final,
                m.frequencia_percentual,
                m.status_aprovacao
        ");

        // Cria a View do Diário do Professor (CORRIGIDA)
        DB::statement("
            CREATE OR REPLACE VIEW vw_diario_professor AS
            SELECT 
                d.nome_disciplina,
                t.semestre_letivo,
                t.id_turma as turma_id,
                a.matricula_aluno,
                p.nome as aluno_nome,
                MAX(CASE WHEN n.descricao_avaliacao = 'P1' THEN n.valor_nota END) as nota_p1,
                MAX(CASE WHEN n.descricao_avaliacao = 'P2' THEN n.valor_nota END) as nota_p2,
                COUNT(CASE WHEN f.presente = false THEN 1 END) as faltas
            FROM matriculas m
            JOIN turmas t ON m.id_turma = t.id_turma
            JOIN disciplinas d ON t.id_disciplina = d.id_disciplina
            JOIN alunos a ON m.id_aluno = a.id_aluno
            JOIN pessoas p ON a.id_pessoa = p.id_pessoa
            LEFT JOIN notas n ON m.id_matricula = n.id_matricula
            LEFT JOIN frequencias f ON m.id_matricula = f.id_matricula
            GROUP BY 
                d.nome_disciplina, 
                t.semestre_letivo, 
                t.id_turma, 
                a.matricula_aluno, 
                p.nome
        ");

        // Cria o Trigger para atualizar o histórico
        DB::statement("
            CREATE TRIGGER tg_atualiza_historico
            AFTER UPDATE ON matriculas
            FOR EACH ROW
            BEGIN
                IF NEW.status_aprovacao IN ('Aprovado', 'Reprovado por Nota', 'Reprovado por Falta') AND 
                   OLD.status_aprovacao != NEW.status_aprovacao THEN
                    INSERT INTO historico_escolares (id_aluno, disciplina_nome, codigo_disciplina, nota_final, status_aprovacao, semestre_letivo, creditos, created_at, updated_at)
                    SELECT 
                        NEW.id_aluno,
                        d.nome_disciplina,
                        d.codigo_disciplina,
                        NEW.nota_final,
                        NEW.status_aprovacao,
                        t.semestre_letivo,
                        d.creditos,
                        NOW(),
                        NOW()
                    FROM turmas t
                    JOIN disciplinas d ON t.id_disciplina = d.id_disciplina
                    WHERE t.id_turma = NEW.id_turma;
                END IF;
            END
        ");

        // Cria o Trigger para verificar vagas
        DB::statement("
            CREATE TRIGGER tg_verifica_vagas_turma
            BEFORE INSERT ON matriculas
            FOR EACH ROW
            BEGIN
                DECLARE vagas_ocupadas INT;
                DECLARE vagas_maximas_turma INT;
                
                SELECT COUNT(*), t.vagas_maximas
                INTO vagas_ocupadas, vagas_maximas_turma
                FROM matriculas m
                JOIN turmas t ON m.id_turma = t.id_turma
                WHERE m.id_turma = NEW.id_turma
                GROUP BY t.vagas_maximas;
                
                IF vagas_ocupadas >= vagas_maximas_turma THEN
                    SIGNAL SQLSTATE '45000' 
                    SET MESSAGE_TEXT = 'Turma lotada. Não há vagas disponíveis.';
                END IF;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP TRIGGER IF EXISTS tg_verifica_vagas_turma');
        DB::statement('DROP TRIGGER IF EXISTS tg_atualiza_historico');
        DB::statement('DROP VIEW IF EXISTS vw_diario_professor');
        DB::statement('DROP VIEW IF EXISTS vw_boletim_aluno');
    }
};
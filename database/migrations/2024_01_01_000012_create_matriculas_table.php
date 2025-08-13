<?php

use Illuminate\Support\Facades\DB; // Certifique-se que esta linha está no topo
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
        // 1. Criamos a tabela com as colunas
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id('id_matricula');
            $table->foreignId('id_aluno')->constrained('alunos', 'id_aluno')->onDelete('cascade');
            $table->foreignId('id_turma')->constrained('turmas', 'id_turma')->onDelete('cascade');
            $table->decimal('nota_final', 4, 2)->nullable();
            $table->enum('status_aprovacao', ['Cursando', 'Aprovado', 'Reprovado', 'Recuperação'])->default('Cursando');
            $table->decimal('frequencia_percentual', 5, 2)->nullable();
            $table->timestamps();
            
            $table->unique(['id_aluno', 'id_turma']);
            $table->index(['id_aluno']);
            $table->index(['id_turma']);
            $table->index(['status_aprovacao']);

            // 2. As duas linhas com $table->check(...) foram REMOVIDAS daqui.
        });

        // 3. Adicionamos as regras aqui embaixo, com SQL puro
        DB::statement('ALTER TABLE matriculas ADD CONSTRAINT chk_nota_final_range CHECK (nota_final IS NULL OR (nota_final >= 0.00 AND nota_final <= 10.00))');
        DB::statement('ALTER TABLE matriculas ADD CONSTRAINT chk_frequencia_range CHECK (frequencia_percentual IS NULL OR (frequencia_percentual >= 0.00 AND frequencia_percentual <= 100.00))');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};
<?php

use Illuminate\Support\Facades\DB; // Adicionado para usar SQL puro
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
        // 1. Cria a tabela com as colunas
        Schema::create('turmas', function (Blueprint $table) {
            $table->id('id_turma');
            $table->string('codigo_turma', 10)->unique();
            $table->foreignId('id_disciplina')->constrained('disciplinas', 'id_disciplina')->onDelete('cascade');
            $table->foreignId('id_professor')->nullable()->constrained('professores', 'id_professor')->onDelete('set null');
            $table->string('semestre_letivo', 10);
            $table->integer('vagas_maximas')->default(50);
            $table->enum('status_turma', ['Aberta', 'Fechada', 'Em Andamento'])->default('Aberta');
            $table->timestamps();
            
            $table->index(['semestre_letivo']);
            $table->index(['status_turma']);

            // 2. A linha $table->check(...) foi REMOVIDA daqui.
        });

        // 3. A regra foi movida para um DB::statement aqui embaixo.
        DB::statement('ALTER TABLE turmas ADD CONSTRAINT chk_vagas_maximas CHECK (vagas_maximas <= 50)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turmas');
    }
};
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
        Schema::create('historico_escolares', function (Blueprint $table) {
            $table->id('id_historico');
            $table->foreignId('id_aluno')->constrained('alunos', 'id_aluno')->onDelete('cascade');
            $table->string('disciplina_nome', 100);
            $table->string('codigo_disciplina', 10);
            $table->decimal('nota_final', 4, 2);
            $table->enum('status_aprovacao', ['Aprovado', 'Reprovado']);
            $table->string('semestre_letivo', 10);
            $table->integer('creditos');
            $table->timestamps();
            
            $table->index(['id_aluno']);
            $table->index(['semestre_letivo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_escolares');
    }
};
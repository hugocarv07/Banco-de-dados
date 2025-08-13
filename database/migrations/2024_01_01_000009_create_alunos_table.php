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
        Schema::create('alunos', function (Blueprint $table) {
            $table->id('id_aluno');
            $table->foreignId('id_pessoa')->constrained('pessoas', 'id_pessoa')->onDelete('cascade');
            $table->string('matricula_aluno', 20)->unique();
            $table->enum('status_aluno', ['Ativo', 'Trancado', 'Jubilado', 'Evadido'])->default('Ativo');
            $table->foreignId('id_curso')->nullable()->constrained('cursos', 'id_curso')->onDelete('set null');
            $table->timestamps();
            
            $table->index(['matricula_aluno']);
            $table->index(['status_aluno']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alunos');
    }
};
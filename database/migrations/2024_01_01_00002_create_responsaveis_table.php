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
        Schema::create('responsaveis', function (Blueprint $table) {
            $table->id('id_responsavel');
            $table->foreignId('id_aluno')->constrained('alunos', 'id_aluno')->onDelete('cascade');
            $table->string('nome', 100);
            $table->string('cpf', 11)->unique();
            $table->string('parentesco', 30);
            $table->string('telefone', 15);
            $table->string('email', 100)->nullable();
            $table->timestamps();
            
            $table->index(['id_aluno']);
            $table->index(['cpf']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responsaveis');
    }
};
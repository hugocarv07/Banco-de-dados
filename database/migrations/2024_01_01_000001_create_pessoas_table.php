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
        Schema::create('pessoas', function (Blueprint $table) {
            $table->id('id_pessoa');
            $table->string('nome', 100);
            $table->string('cpf', 11)->unique();
            $table->date('data_nascimento');
            $table->string('email', 100)->unique();
            $table->string('telefone', 15)->nullable(); // Adicionado nullable para flexibilidade
            $table->text('endereco')->nullable();      // Adicionado nullable para flexibilidade
            $table->string('tipo_pessoa'); // 'aluno', 'professor', 'funcionario'

            // LINHA ADICIONADA: Essencial para o login funcionar
            $table->string('password');

            $table->timestamps();
            
            // As linhas de índice abaixo foram removidas pois o método ->unique()
            // nas colunas 'cpf' e 'email' já cria os índices necessários automaticamente.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pessoas');
    }
};
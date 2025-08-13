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
        Schema::create('disciplinas', function (Blueprint $table) {
            $table->id('id_disciplina');
            $table->string('nome_disciplina', 100);
            $table->string('codigo_disciplina', 10)->unique();
            $table->integer('creditos');
            $table->text('ementa');
            $table->integer('carga_horaria');
            $table->foreignId('id_departamento')->constrained('departamentos', 'id_departamento')->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['codigo_disciplina']);
            $table->index(['nome_disciplina']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disciplinas');
    }
};
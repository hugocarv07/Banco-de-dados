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
        Schema::create('cursos', function (Blueprint $table) {
            $table->id('id_curso');
            $table->string('nome_curso', 100);
            $table->integer('duracao_semestres');
            $table->foreignId('id_departamento')->constrained('departamentos', 'id_departamento')->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['nome_curso']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
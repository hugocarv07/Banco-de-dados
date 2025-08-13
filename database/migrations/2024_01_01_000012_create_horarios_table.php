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
        Schema::create('horarios', function (Blueprint $table) {
            $table->id('id_horario');
            $table->foreignId('id_turma')->constrained('turmas', 'id_turma')->onDelete('cascade');
            $table->foreignId('id_sala')->nullable()->constrained('salas', 'id_sala')->onDelete('set null');
            $table->enum('dia_semana', ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado']);
            $table->time('hora_inicio');
            $table->time('hora_fim');
            $table->timestamps();
            
            $table->index(['dia_semana']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
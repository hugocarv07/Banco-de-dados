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
        Schema::create('frequencias', function (Blueprint $table) {
            $table->id('id_frequencia');
            $table->foreignId('id_matricula')->constrained('matriculas', 'id_matricula')->onDelete('cascade');
            $table->date('data_aula');
            $table->boolean('presente')->default(true);
            $table->timestamps();
            
            $table->index(['id_matricula']);
            $table->index(['data_aula']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frequencias');
    }
};
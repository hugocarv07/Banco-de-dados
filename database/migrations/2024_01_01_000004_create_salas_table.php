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
        Schema::create('salas', function (Blueprint $table) {
            $table->id('id_sala');
            $table->string('numero_sala', 10);
            $table->string('bloco', 5);
            $table->integer('capacidade');
            $table->timestamps();
            
            $table->unique(['numero_sala', 'bloco']);
            $table->index(['bloco']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salas');
    }
};
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
        Schema::create('funcionario_admins', function (Blueprint $table) {
            $table->id('id_funcionario');
            $table->foreignId('id_pessoa')->constrained('pessoas', 'id_pessoa')->onDelete('cascade');
            $table->string('cargo', 50);
            $table->date('data_admissao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funcionario_admins');
    }
};
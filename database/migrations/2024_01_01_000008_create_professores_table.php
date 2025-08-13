<?php

use Illuminate\Support\Facades\DB; // Adicionado para usar SQL puro
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
        // 1. Cria a tabela com as colunas
        Schema::create('professores', function (Blueprint $table) {
            $table->id('id_professor');
            $table->foreignId('id_pessoa')->constrained('pessoas', 'id_pessoa')->onDelete('cascade');
            $table->string('matricula_professor', 20)->unique();
            $table->decimal('salario', 10, 2);
            $table->enum('titulacao', ['Graduado', 'Especialista', 'Mestre', 'Doutor']);
            $table->foreignId('id_departamento')->nullable()->constrained('departamentos', 'id_departamento')->onDelete('set null');
            $table->integer('carga_horaria_semanal')->default(0);
            $table->timestamps();
            
            $table->index(['matricula_professor']); // Lembre-se, esta linha é opcional, pois ->unique() já cria um índice.

        });

        // 3. A regra foi movida para um DB::statement aqui embaixo.
        DB::statement('ALTER TABLE professores ADD CONSTRAINT chk_carga_horaria_professor CHECK (carga_horaria_semanal <= 20)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professores');
    }
};
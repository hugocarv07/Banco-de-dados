<?php

use Illuminate\Support\Facades\DB; // Adicionado
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
        // 1. Cria a tabela
        Schema::create('notas', function (Blueprint $table) {
            $table->id('id_nota');
            $table->foreignId('id_matricula')->constrained('matriculas', 'id_matricula')->onDelete('cascade');
            $table->string('descricao_avaliacao', 50);
            $table->decimal('valor_nota', 4, 2);
            $table->decimal('peso', 3, 2)->default(1.0);
            $table->timestamps();
            
            $table->index(['id_matricula']);
            
            // 2. A linha $table->check(...) foi REMOVIDA daqui
        });

        // 3. A regra foi movida para cá, usando SQL puro
        DB::statement('ALTER TABLE notas ADD CONSTRAINT chk_valor_nota_range CHECK (valor_nota >= 0.00 AND valor_nota <= 10.00)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas');
    }
};
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoEscolar extends Model
{
    use HasFactory;

    protected $table = 'historico_escolares';
    protected $primaryKey = 'id_historico';

    protected $fillable = [
        'id_aluno',
        'disciplina_nome',
        'codigo_disciplina',
        'nota_final',
        'status_aprovacao',
        'semestre_letivo',
        'creditos'
    ];

    protected $casts = [
        'nota_final' => 'decimal:2'
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'id_aluno', 'id_aluno');
    }
}
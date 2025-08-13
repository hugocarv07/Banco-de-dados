<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;

    protected $table = 'turmas';
    protected $primaryKey = 'id_turma';

    protected $fillable = [
        'codigo_turma',
        'id_disciplina',
        'id_professor',
        'semestre_letivo',
        'vagas_maximas',
        'status_turma'
    ];

    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class, 'id_disciplina', 'id_disciplina');
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class, 'id_professor', 'id_professor');
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class, 'id_turma', 'id_turma');
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class, 'id_turma', 'id_turma');
    }

    public function getVagasDisponiveisAttribute()
    {
        return $this->vagas_maximas - $this->matriculas()->count();
    }
}
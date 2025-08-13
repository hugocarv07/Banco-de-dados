<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;

    protected $table = 'matriculas';
    protected $primaryKey = 'id_matricula';

    protected $fillable = [
        'id_aluno',
        'id_turma',
        'nota_final',
        'status_aprovacao',
        'frequencia_percentual'
    ];

    protected $casts = [
        'nota_final' => 'decimal:2',
        'frequencia_percentual' => 'decimal:2'
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'id_aluno', 'id_aluno');
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class, 'id_turma', 'id_turma');
    }

    public function notas()
    {
        return $this->hasMany(Nota::class, 'id_matricula', 'id_matricula');
    }

    public function frequencias()
    {
        return $this->hasMany(Frequencia::class, 'id_matricula', 'id_matricula');
    }
}
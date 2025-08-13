<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    use HasFactory;

    protected $table = 'disciplinas';
    protected $primaryKey = 'id_disciplina';

    protected $fillable = [
        'nome_disciplina',
        'codigo_disciplina',
        'creditos',
        'ementa',
        'carga_horaria',
        'id_departamento'
    ];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento', 'id_departamento');
    }

    public function turmas()
    {
        return $this->hasMany(Turma::class, 'id_disciplina', 'id_disciplina');
    }

    public function preRequisitos()
    {
        return $this->belongsToMany(
            Disciplina::class,
            'pre_requisitos',
            'disciplina_id',
            'pre_requisito_id',
            'id_disciplina',
            'id_disciplina'
        );
    }

    public function dependentes()
    {
        return $this->belongsToMany(
            Disciplina::class,
            'pre_requisitos',
            'pre_requisito_id',
            'disciplina_id',
            'id_disciplina',
            'id_disciplina'
        );
    }
}
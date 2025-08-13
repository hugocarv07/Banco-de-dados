<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;

    protected $table = 'professores';
    protected $primaryKey = 'id_professor';

    protected $fillable = [
        'id_pessoa',
        'matricula_professor',
        'salario',
        'titulacao',
        'id_departamento',
        'carga_horaria_semanal'
    ];

    protected $casts = [
        'salario' => 'decimal:2',
        'carga_horaria_semanal' => 'integer'
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'id_pessoa', 'id_pessoa');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento', 'id_departamento');
    }

    public function turmas()
    {
        return $this->hasMany(Turma::class, 'id_professor', 'id_professor');
    }
}
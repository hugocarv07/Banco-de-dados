<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $table = 'departamentos';
    protected $primaryKey = 'id_departamento';

    protected $fillable = [
        'nome_departamento',
        'descricao'
    ];

    public function cursos()
    {
        return $this->hasMany(Curso::class, 'id_departamento', 'id_departamento');
    }

    public function disciplinas()
    {
        return $this->hasMany(Disciplina::class, 'id_departamento', 'id_departamento');
    }

    public function professores()
    {
        return $this->hasMany(Professor::class, 'id_departamento', 'id_departamento');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;

    protected $table = 'alunos';
    protected $primaryKey = 'id_aluno';

    protected $fillable = [
        'id_pessoa',
        'matricula_aluno',
        'status_aluno',
        'id_curso'
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'id_pessoa', 'id_pessoa');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso', 'id_curso');
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class, 'id_aluno', 'id_aluno');
    }

    public function responsaveis()
    {
        return $this->hasMany(Responsavel::class, 'id_aluno', 'id_aluno');
    }

    public function historicoEscolar()
    {
        return $this->hasMany(HistoricoEscolar::class, 'id_aluno', 'id_aluno');
    }
}
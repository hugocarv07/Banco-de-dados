<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsavel extends Model
{
    use HasFactory;

    protected $table = 'responsaveis';
    protected $primaryKey = 'id_responsavel';

    protected $fillable = [
        'id_aluno',
        'nome',
        'cpf',
        'parentesco',
        'telefone',
        'email'
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'id_aluno', 'id_aluno');
    }
}
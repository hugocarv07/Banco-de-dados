<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pessoa extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pessoas';
    protected $primaryKey = 'id_pessoa';

    protected $fillable = [
        'nome',
        'cpf',
        'data_nascimento',
        'email',
        'telefone',
        'endereco',
        'tipo_pessoa',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function aluno()
    {
        return $this->hasOne(Aluno::class, 'id_pessoa', 'id_pessoa');
    }

    public function professor()
    {
        return $this->hasOne(Professor::class, 'id_pessoa', 'id_pessoa');
    }

    public function funcionarioAdmin()
    {
        return $this->hasOne(FuncionarioAdmin::class, 'id_pessoa', 'id_pessoa');
    }

    public function isAluno()
    {
        return $this->tipo_pessoa === 'aluno';
    }

    public function isProfessor()
    {
        return $this->tipo_pessoa === 'professor';
    }

    public function isFuncionario()
    {
        return $this->tipo_pessoa === 'funcionario';
    }
}
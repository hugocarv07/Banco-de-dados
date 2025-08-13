<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncionarioAdmin extends Model
{
    use HasFactory;

    protected $table = 'funcionario_admins';
    protected $primaryKey = 'id_funcionario';

    protected $fillable = [
        'id_pessoa',
        'cargo',
        'data_admissao'
    ];

    protected $casts = [
        'data_admissao' => 'date'
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'id_pessoa', 'id_pessoa');
    }
}
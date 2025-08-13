<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    use HasFactory;

    protected $table = 'salas';
    protected $primaryKey = 'id_sala';

    protected $fillable = [
        'numero_sala',
        'bloco',
        'capacidade'
    ];

    public function horarios()
    {
        return $this->hasMany(Horario::class, 'id_sala', 'id_sala');
    }
}
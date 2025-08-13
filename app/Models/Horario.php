<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $table = 'horarios';
    protected $primaryKey = 'id_horario';

    protected $fillable = [
        'id_turma',
        'id_sala',
        'dia_semana',
        'hora_inicio',
        'hora_fim'
    ];

    protected $casts = [
        'hora_inicio' => 'datetime:H:i',
        'hora_fim' => 'datetime:H:i'
    ];

    public function turma()
    {
        return $this->belongsTo(Turma::class, 'id_turma', 'id_turma');
    }

    public function sala()
    {
        return $this->belongsTo(Sala::class, 'id_sala', 'id_sala');
    }
}
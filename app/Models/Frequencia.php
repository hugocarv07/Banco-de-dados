<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frequencia extends Model
{
    use HasFactory;

    protected $table = 'frequencias';
    protected $primaryKey = 'id_frequencia';

    protected $fillable = [
        'id_matricula',
        'data_aula',
        'presente'
    ];

    protected $casts = [
        'data_aula' => 'date',
        'presente' => 'boolean'
    ];

    public function matricula()
    {
        return $this->belongsTo(Matricula::class, 'id_matricula', 'id_matricula');
    }
}
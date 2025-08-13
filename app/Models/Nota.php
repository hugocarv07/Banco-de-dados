<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;

    protected $table = 'notas';
    protected $primaryKey = 'id_nota';

    protected $fillable = [
        'id_matricula',
        'descricao_avaliacao',
        'valor_nota',
        'peso'
    ];

    protected $casts = [
        'valor_nota' => 'decimal:2',
        'peso' => 'decimal:2'
    ];

    public function matricula()
    {
        return $this->belongsTo(Matricula::class, 'id_matricula', 'id_matricula');
    }
}
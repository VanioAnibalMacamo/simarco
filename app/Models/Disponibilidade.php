<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disponibilidade extends Model
{
    use HasFactory;

    protected $fillable = [
        'dia_semana',
        'hora_inicio',
        'hora_fim',
        'estado',
        'medico_id',
    ];

    // Relacionamento com o modelo Medico
    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }

    // Métodos adicionais, como validações ou outros relacionamentos, podem ser adicionados aqui
}

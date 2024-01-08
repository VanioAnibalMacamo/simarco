<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_consulta',
        'hora_inicio',
        'hora_fim',
        'id_status',
        'observacoes',
    ];

    // Relacionamento com StatusConsulta
    public function statusConsulta()
    {
        return $this->belongsTo(StatusConsulta::class, 'id_status');
    }
}

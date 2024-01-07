<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_consulta',
        'duracao',
        'id_status',
        'observacoes',
        'numero_identificacao',
    ];

    public function statusConsulta()
    {
        return $this->belongsTo(StatusConsulta::class, 'id_status');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusConsulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao',
        'status_antecessor_id',
    ];

    // Relacionamento inverso com Consulta
    public function consultas()
    {
        return $this->hasMany(Consulta::class, 'id_status');
    }

    // Relacionamento com o status antecessor
    public function statusAntecessor()
    {
        return $this->belongsTo(StatusConsulta::class, 'status_antecessor_id');
    }
}

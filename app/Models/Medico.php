<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'especialidade_id', // Corrigido para refletir a chave estrangeira
        'numero_identificacao',
        'disponibilidade',
        'genero',
    ];

    public function especialidade()
    {
        return $this->belongsTo(Especialidade::class);
    }
}

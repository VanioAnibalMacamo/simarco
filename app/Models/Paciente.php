<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'data_nascimento',
        'genero',
        'numero_identificacao',
        'endereco',
        'telefone',
        'email',
    ];

    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }
}

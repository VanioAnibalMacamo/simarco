<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'especialidade_id',
        'numero_identificacao',
        'disponibilidade',
        'genero',
        'imagem', // novo campo para armazenar o nome da imagem
    ];

    public function especialidade()
    {
        return $this->belongsTo(Especialidade::class);
    }
    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }

    public function disponibilidades()
    {
        return $this->hasMany(Disponibilidade::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'medico_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable; // Importe a trait Notifiable

class Paciente extends Model
{
    use HasFactory, Notifiable; // Adicione a trait Notifiable aqui

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

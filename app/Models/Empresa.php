<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'sigla',
        'nuit',
        'email',
        'contacto1',
        'contacto2',
        'localizacao'
    ];
    public function pacientes()
    {
        return $this->hasMany(Paciente::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fabricante extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'endereco',
        'contacto',

    ];
    // Relacionamento com Medicamentos
    public function medicamentos()
    {
        return $this->hasMany(Medicamento::class);
    }
}

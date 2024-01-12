<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViaAdministracao extends Model
{
    use HasFactory;
    protected $fillable = ['descricao'];

    // Relacionamento com Medicamentos
    public function medicamentos()
    {
        return $this->hasMany(Medicamento::class);
    }
}

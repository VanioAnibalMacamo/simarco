<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_diagnostico',
        'descricao',
        'observacoes',
        'consulta_id', // Adicionando a chave estrangeira
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}

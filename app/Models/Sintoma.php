<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sintoma extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao',
        'duracao',
        'consulta_id',
        'gravidade_id', // Adicionando a chave estrangeira para gravidade
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }

    public function gravidade()
    {
        return $this->belongsTo(Gravidade::class); // Adicionando a relação com Gravidade
    }
}

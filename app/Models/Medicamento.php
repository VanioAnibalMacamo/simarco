<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_medicamento',
        'substancias_quimicas',
        'dosagem',
        'fabricante_id',
        'numero_registo',
        'data_fabricacao',
        'forma_farmaceutica_id',
        'via_administracao_id',
        'data_validade',
        'indicacoes',
        'contraindicacoes',
        'efeitos_colaterais',
        'instrucoes_uso',
        'armazenamento',
        'preco',
        'disponibilidade',
    ];

    // Relacionamento com Fabricante
    public function fabricante()
    {
        return $this->belongsTo(Fabricante::class);
    }

    // Relacionamento com FormaFarmaceutica
    public function formaFarmaceutica()
    {
        return $this->belongsTo(FormaFarmaceutica::class);
    }

    // Relacionamento com ViaAdministracao
    public function viaAdministracao()
    {
        return $this->belongsTo(ViaAdministracao::class);
    }

    public function prescricoes()
    {
        return $this->belongsToMany(Medicamento::class, 'prescricao_medicamento')
                     ->withPivot('dosagem', 'instrucoes');
    }
}

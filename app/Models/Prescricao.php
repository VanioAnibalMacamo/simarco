<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescricao extends Model
{
    use HasFactory;
    protected $table = 'prescricoes';
    protected $fillable = [
        'data_prescricao',
        'observacoes',
        'dosagem',
        'medicamentos',
        'consulta_id',
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}

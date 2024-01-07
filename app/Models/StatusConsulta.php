<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusConsulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao',
    ];

    public function consultas()
    {
        return $this->hasMany(Consulta::class, 'id_status');
    }
}

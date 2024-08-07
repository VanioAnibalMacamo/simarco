<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'dia',
        'paciente_id',
        'horario',
        'consulta_id',
    ];

    protected $casts = [
        'dia' => 'datetime',
        'horario' => 'string',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function disponibilidades()
    {
        return $this->belongsToMany(Disponibilidade::class, 'agendamento_disponibilidade')
            ->withTimestamps();
    }

    public function consulta()
    {
        return $this->hasOne(Consulta::class, 'agendamento_id');
    }
}

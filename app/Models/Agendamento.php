<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;

    // Adicione 'horario' ao array $fillable
    protected $fillable = [
        'dia',
        'paciente_id',
        'horario', // Adicione isto
    ];

    // Se 'horario' for armazenado como um string, não precisa de casting
    // Se 'horario' for armazenado como um tipo datetime ou time, considere usar 'time' no cast
    protected $casts = [
        'dia' => 'datetime',
       // 'horario' => 'time', 
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
}

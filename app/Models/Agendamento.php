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
    ];

    protected $casts = [
        'dia' => 'datetime', // Garante que o campo 'dia' seja tratado como um objeto DateTime
    ];

    // Relacionamento com Paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    // Relacionamento muitos para muitos com Disponibilidade
    public function disponibilidades()
    {
        return $this->belongsToMany(Disponibilidade::class)
                    ->withTimestamps();
    }
}

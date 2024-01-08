<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_consulta',
        'hora_inicio',
        'hora_fim',
        'id_status',
        'observacoes',
    ];

    public function getDuracaoFormatadaAttribute()
    {
        $horaInicio = \Carbon\Carbon::parse($this->hora_inicio);
        $horaFim = \Carbon\Carbon::parse($this->hora_fim);
        $duracaoEmMinutos = $horaInicio->diffInMinutes($horaFim);

        $formato = $horaInicio->format('A'); // Retorna AM ou PM

        return sprintf('%02d:%02d %s', $duracaoEmMinutos / 60, $duracaoEmMinutos % 60, $formato);
    }


    // Relacionamento com StatusConsulta
    public function statusConsulta()
    {
        return $this->belongsTo(StatusConsulta::class, 'id_status');
    }
    public function medicos()
{
    return $this->belongsToMany(Medico::class, 'consulta_medico')->withTimestamps();
}

public function pacientes()
{
    return $this->belongsToMany(Paciente::class, 'consulta_paciente')->withTimestamps();
}
}

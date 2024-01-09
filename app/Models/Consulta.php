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

        $horas = floor($duracaoEmMinutos / 60);
        $minutos = $duracaoEmMinutos % 60;

        $duracaoFormatada = '';

        if ($horas > 0) {
            $duracaoFormatada .= ($horas == 1) ? '1 hora' : $horas . ' horas';
        }

        if ($minutos > 0) {
            if ($horas > 0) {
                $duracaoFormatada .= ($minutos == 1) ? ' e 1 minuto' : ' e ' . $minutos . ' minutos';
            } else {
                $duracaoFormatada .= ($minutos == 1) ? '1 minuto' : $minutos . ' minutos';
            }
        }

        return $duracaoFormatada;
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

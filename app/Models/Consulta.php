<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_consulta',
        'hora_inicio',
        'hora_fim',
        'observacoes',
        'medico_id',
        'paciente_id',
        'fotos_zip',
        'agendamento_id',
        'foto_1',
        'foto_2',
    ];

    public function getDuracaoFormatadaAttribute()
    {
        $horaInicio = Carbon::parse($this->hora_inicio);
        $horaFim = Carbon::parse($this->hora_fim);
        $duracao = $horaInicio->diff($horaFim);

        $duracaoFormatada = '';
        if ($duracao->h > 0) {
            $duracaoFormatada .= ($duracao->h == 1) ? '1 hora' : $duracao->h . ' horas';
        }

        if ($duracao->i > 0) {
            if ($duracao->h > 0) {
                $duracaoFormatada .= ($duracao->i == 1) ? ' e 1 minuto' : ' e ' . $duracao->i . ' minutos';
            } else {
                $duracaoFormatada .= ($duracao->i == 1) ? '1 minuto' : $duracao->i . ' minutos';
            }
        }

        return $duracaoFormatada;
    }

    public function medico()
    {
        return $this->belongsTo(Medico::class, 'medico_id');
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function diagnostico()
    {
        return $this->hasOne(Diagnostico::class);
    }

    public function prescricao()
    {
        return $this->hasOne(Prescricao::class);
    }

    public function sintoma()
    {
        return $this->hasOne(Sintoma::class, 'consulta_id');
    }

    public function agendamento()
    {
        return $this->belongsTo(Agendamento::class, 'agendamento_id');
    }
}

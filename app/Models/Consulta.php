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
        'medico_id', // Adicione estas linhas para refletir as alterações nas migrações
        'paciente_id', // Adicione estas linhas para refletir as alterações nas migrações
    ];

    public function getDuracaoFormatadaAttribute()
    {
        $horaInicio = \Carbon\Carbon::parse($this->hora_inicio);
        $horaFim = \Carbon\Carbon::parse($this->hora_fim);
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

        // Não inclui os segundos na formatação

        return $duracaoFormatada;
    }

    public function statusConsulta()
    {
        return $this->belongsTo(StatusConsulta::class, 'id_status');
    }

    public function medico()
    {
        return $this->belongsTo(Medico::class, 'medico_id');
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }
}

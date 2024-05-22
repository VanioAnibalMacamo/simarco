<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\FormaPagamentoEnum;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_consulta',
        'hora_inicio',
        'hora_fim',
        'id_status',
        'observacoes',
        'medico_id',
        'paciente_id',
        'forma_pagamento',
    ];

    protected $casts = [
        'forma_pagamento' => FormaPagamentoEnum::class, // Configuração do casting do Enum
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

    public function diagnostico()
    {
        return $this->hasOne(Diagnostico::class);
    }

    public function prescricao()
    {
        return $this->hasOne(Prescricao::class);
    }

    public function status_antecessor()
    {
        return $this->belongsTo(StatusConsulta::class, 'status_antecessor_id');
    }

    public function sintoma()
    {
        return $this->hasOne(Sintoma::class, 'consulta_id');
    }
}

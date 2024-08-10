<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\FormaPagamentoEnum;
use InvalidArgumentException;

class Agendamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'dia',
        'paciente_id',
        'horario',
        'consulta_id',
        'forma_pagamento',
    ];

    protected $casts = [
        'dia' => 'datetime',
        'horario' => 'string',
        'forma_pagamento' => FormaPagamentoEnum::class, // Casting do Enum
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

    
    public function setFormaPagamentoAttribute($value)
    {
        try {
            $this->attributes['forma_pagamento'] = FormaPagamentoEnum::from($value)->value;
        } catch (InvalidArgumentException $e) {
            \Log::error('Forma de pagamento inválida:', ['value' => $value]);
            throw new \InvalidArgumentException('Forma de pagamento inválida.');
        }
    }
}

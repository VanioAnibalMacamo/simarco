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
    ];

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

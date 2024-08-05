<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disponibilidade extends Model
{
    use HasFactory;

    protected $fillable = [
        'dia_semana',
        'medico_id',
    ];

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }

    public function agendamentos()
    {
        return $this->belongsToMany(Agendamento::class, 'agendamento_disponibilidade')
            ->withTimestamps();
    }
}

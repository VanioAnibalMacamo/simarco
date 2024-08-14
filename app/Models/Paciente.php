<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Paciente extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nome',
        'data_nascimento',
        'genero',
        'numero_identificacao',
        'endereco',
        'telefone',
        'email',
        'empresa_id',
        'codigo_funcionario',
        'cartao_seguro_saude',
    ];

    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }

    // Relacionamento um para muitos com Agendamento
    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }
    // Relacionamento muitos para um com Empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'paciente_id');
    }
}

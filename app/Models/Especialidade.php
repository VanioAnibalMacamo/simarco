<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidade extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable = ['descricao', 'preco'];

    public $timestamps = false;

    public function medicos()
    {
        return $this->hasMany(Medico::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gravidade extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao',
    ];

    public $timestamps = false;

    public function sintomas()
    {
        return $this->hasMany(Sintoma::class);
    }
}

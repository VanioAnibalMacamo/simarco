<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaFarmaceutica extends Model
{
    use HasFactory;
    protected $fillable = ['descricao'];
    protected $table = 'formas_farmaceuticas';

}

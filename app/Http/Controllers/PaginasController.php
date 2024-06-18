<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Especialidade;

class PaginasController extends Controller
{
    public function pacienteTipoConsulta()
    {
        $especialidades = Especialidade::all();
        return view('paginas.pacienteTipoConsulta', ['especialidades' => $especialidades]);
    }


}

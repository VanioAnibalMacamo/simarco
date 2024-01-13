<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Consulta;
use App\Models\Medicamento;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       // Contar o número de registros em cada tabela
       $numMedicos = Medico::count();
       $numPacientes = Paciente::count();
       $numConsultas = Consulta::count();
       $numMedicamentos = Medicamento::count();

       // Passar os valores para a view
       return view('home', compact('numMedicos', 'numPacientes', 'numConsultas', 'numMedicamentos'));
    }
}

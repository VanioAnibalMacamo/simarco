<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agendamento;

class VideoConferenciaController extends Controller
{
    //

    public function index()
    {
        return view('video_conferencia.videoconferencia');
    }

    public function videoconferencia($id)
    {
        $agendamento = Agendamento::with('paciente', 'disponibilidades.medico.especialidade')->findOrFail($id);
        return view('video_conferencia.videoconferencia', compact('agendamento'));
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agendamento;
use App\Models\Medicamento;

class VideoConferenciaController extends Controller
{
    // Função para carregar a view de videoconferência
    public function index()
    {
        return view('video_conferencia.videoconferencia');
    }

    // Função para lidar com a videoconferência e salvar diagnóstico e prescrição
    public function videoconferencia($id)
    {
        $agendamento = Agendamento::with('paciente', 'disponibilidades.medico.especialidade')->findOrFail($id);

        // Buscar medicamentos disponíveis
        $medicamentos = Medicamento::all();

        return view('video_conferencia.videoconferencia', compact('agendamento', 'medicamentos'));
    }
}

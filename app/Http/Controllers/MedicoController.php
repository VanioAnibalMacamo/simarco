<?php

namespace App\Http\Controllers;

use App\Enums\DisponibilidadeEnum;
use App\Enums\GeneroEnum;
use App\Models\Especialidade;
use App\Models\Medico;
use App\Models\Disponibilidade;
use App\Models\Paciente;
use App\Models\Agendamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MedicoController extends Controller
{
    public function index()
    {
        $medicos = Medico::paginate(8);
        return view('medico.index', ['medicos' => $medicos]);
    }

    public function create()
    {
        $especialidades = Especialidade::all();
        $disponibilidades = DisponibilidadeEnum::getConstants();
        $generos = GeneroEnum::getConstants();

        return view('medico.create', compact('especialidades', 'disponibilidades', 'generos'));
    }

    public function saveMedico(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'especialidade_id' => 'required|exists:especialidades,id',
            'numero_identificacao' => 'required|string|max:50',
            'disponibilidade' => 'required|string|max:255',
            'genero' => 'required|in:' . implode(',', GeneroEnum::getConstants()),
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validar a imagem
        ]);

        // Salvar a imagem
        $imagemNome = $request->file('imagem')->getClientOriginalName();
        $request->file('imagem')->storeAs('public/images/medicos', $imagemNome);

        // Criar o médico com os dados
        Medico::create([
            'nome' => $request->input('nome'),
            'especialidade_id' => $request->input('especialidade_id'),
            'numero_identificacao' => $request->input('numero_identificacao'),
            'disponibilidade' => $request->input('disponibilidade'),
            'genero' => $request->input('genero'),
            'imagem' => $imagemNome, // Salvar o nome da imagem
        ]);

        return redirect('/medicoIndex')->with('success', 'Médico salvo com sucesso!');
    }
    public function delete($id)
    {
        $medico = Medico::findOrFail($id);
        $medico->delete();

        return redirect('/medicoIndex')->with('successDelete', 'Médico excluído com sucesso!');
    }

    public function show($id)
    {
        $medico = Medico::findOrFail($id);

        return view('medico.view', ['medico' => $medico]);
    }

    public function edit($id)
    {
        $medico = Medico::findOrFail($id);
        $especialidades = Especialidade::all();
        $disponibilidades = DisponibilidadeEnum::getConstants();
        $generos = GeneroEnum::getConstants();

        return view('medico.edit', compact('medico', 'especialidades', 'disponibilidades', 'generos'));
    }




    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'especialidade_id' => 'required|exists:especialidades,id',
            'numero_identificacao' => 'required|string|max:255',
            'disponibilidade' => 'required|string|max:255',
            'genero' => 'required|in:' . implode(',', GeneroEnum::getConstants()),
        ]);

        $medico = Medico::findOrFail($id);
        $medico->update($request->all());

        return redirect('/medicoIndex')->with('success', 'Médico atualizado com sucesso!');
    }


    public function especialidades()
    {
        $especialidades = Especialidade::all(); // Obtém todas as especialidades do banco de dados

        return view('medico.especialidades', ['especialidades' => $especialidades]);
    }

    public function medicos($idEspecialidade)
    {
        // Lógica para obter os médicos da especialidade com o ID fornecido
        $medicos = Medico::where('especialidade_id', $idEspecialidade)->get();

        return view('medico.medicos', ['medicos' => $medicos]);
    }

    public function showDisponibilidade($id)
    {
        // Busca o médico pelo ID
        $medico = Medico::findOrFail($id);

        // Buscar disponibilidades ativas do médico
        $disponibilidades = Disponibilidade::where('medico_id', $medico->id)
            ->where('estado', 'Activa')
            ->get();

        // Gerar datas para os próximos 30 dias
        $proximasDisponibilidades = [];

        foreach ($disponibilidades as $disponibilidade) {
            $datas = $this->gerarProximasDatas($disponibilidade->dia_semana);

            foreach ($datas as $data) {
                // Formatar a data para o formato adequado para comparação
                $dataFormatada = $data->format('Y-m-d');

                // Verifica se já existe um agendamento para esta data e disponibilidade
                $existeAgendamento = Agendamento::whereHas('disponibilidades', function($query) use ($disponibilidade) {
                    $query->where('disponibilidade_id', $disponibilidade->id);
                })
                ->whereDate('dia', $dataFormatada)
                ->exists();

                // Se não existe um agendamento para esta data e disponibilidade, adiciona à lista
                if (!$existeAgendamento) {
                    $proximasDisponibilidades[] = (object) [
                        'id' => $disponibilidade->id,
                        'dia_semana' => $disponibilidade->dia_semana,
                        'data' => $data->format('d/m/Y'),
                        'data_raw' => $data,
                        'hora_inicio' => $disponibilidade->hora_inicio,
                        'hora_fim' => $disponibilidade->hora_fim,
                        'estado' => $disponibilidade->estado
                    ];
                }
            }
        }

        // Ordenar as disponibilidades
        usort($proximasDisponibilidades, function($a, $b) {
            $dataA = $a->data_raw->getTimestamp();  // Obtém o timestamp da data
            $dataB = $b->data_raw->getTimestamp(); // Obtém o timestamp da data
            $horaA = strtotime($a->hora_inicio);  // Converte hora_inicio para timestamp
            $horaB = strtotime($b->hora_inicio); // Converte hora_inicio para timestamp

            if ($dataA === $dataB) {
                return $horaA - $horaB; // Compara as horas se as datas forem iguais
            }
            return $dataA - $dataB; // Compara as datas
        });

        // Busca todos os pacientes
        $pacientes = Paciente::all();

        // Retorna a view com os dados necessários
        return view('medico.disponibilidades', compact('medico', 'proximasDisponibilidades', 'pacientes'));
    }












    private function gerarProximasDatas($diaSemana)
    {
        $diasDaSemana = [
            'Segunda' => 1,
            'Terça' => 2,
            'Quarta' => 3,
            'Quinta' => 4,
            'Sexta' => 5,
        ];

        $hoje = now();
        $proximos30Dias = collect();

        for ($i = 0; $i < 30; $i++) {
            $dia = $hoje->copy()->addDays($i);
            if ($dia->dayOfWeek === $diasDaSemana[$diaSemana]) {
                $proximos30Dias->push($dia);
            }
        }

        return $proximos30Dias;
    }
}

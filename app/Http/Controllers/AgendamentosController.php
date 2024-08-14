<?php

namespace App\Http\Controllers;

use App\Enums\FormaPagamentoEnum;
use Illuminate\Http\Request;
use App\Models\Agendamento;
use App\Models\Paciente;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\EmailController;

class AgendamentosController extends Controller
{
    public function index()
    {
        $formasPagamento = FormaPagamentoEnum::getValues();
        $agendamentos = Agendamento::with('disponibilidades.medico.especialidade')->get();
        return view('consultas.index', compact('agendamentos'));
    }

    public function agendamentosMarcados()
    {
        $user = auth()->user(); // Obter o usuário autenticado

        // Inicializa a query base com as relações necessárias
        $query = Agendamento::with([
            'paciente',
            'disponibilidades.medico',
            'consulta.diagnostico',
            'consulta.prescricao',
            'consulta.medico',
            'consulta.paciente'
        ]);

        // Verifica o tipo de usuário e aplica os filtros adequados
        if ($user->paciente_id) {
            // Se o usuário for um paciente, filtra os agendamentos por ele
            $query->where('paciente_id', $user->paciente_id);
        } elseif ($user->medico_id) {
            // Se o usuário for um médico, filtra os agendamentos por ele
            $query->whereHas('disponibilidades', function ($q) use ($user) {
                $q->where('medico_id', $user->medico_id);
            });
        } elseif (!$user->hasPermissionTo('view consultas')) {
            // Verifica se o usuário tem a permissão específica para ver agendamentos
            return abort(403, 'Você não tem permissão para visualizar esses agendamentos.');
        }

        // Ordena os resultados
        $agendamentos = $query->orderBy('dia')
            ->orderBy('horario')
            ->paginate(8);

        return view('agendamentos.marcados', compact('agendamentos'));
    }


    public function create()
    {
        // Carregar dados necessários para a criação de um agendamento, se necessário
        $formasPagamento = FormaPagamentoEnum::getValues();
        return view('agendamentos.create', compact('formasPagamento'));
    }

    public function store(Request $request)
    {
        // Valida os dados recebidos
        $validatedData = $this->validateRequest($request);

        // Busca o paciente
        $paciente = Paciente::find($validatedData['paciente_id']);

        // Verifica a forma de pagamento e obtém erros, se houver
        $error = $this->checkFormaPagamento($validatedData['forma_pagamento'], $paciente);

        if ($error) {
            // Se houver um erro, redireciona com a mensagem de erro
            return back()->with(['error' => $error])->withInput();
        }

        try {
            // Cria o agendamento com os dados validados
            $agendamento = $this->createAgendamento($validatedData);

            // Associa a disponibilidade ao agendamento, se necessário
            $this->associateDisponibilidade($agendamento, $validatedData['disponibilidade_id']);

            // Processa o upload do cartão de seguro de saúde, se necessário
            $this->processarUploadCartao($request, $agendamento);

            // Formata o dia para o formato dd/mm/aaaa
            $diaFormatado = Carbon::parse($agendamento->dia)->format('d/m/Y');
            // Formata a hora para o formato HH:mm (sem segundos)
            $horaFormatada = Carbon::parse($agendamento->horario)->format('H:i');

            // Formata o texto do e-mail
            $mensagem = "Caro(a) " . $paciente->nome . ", a sua consulta foi marcada para o dia " . $diaFormatado . " às " . $horaFormatada . ". Deve entrar no sistema e acessar a teleconsulta.\n\nMelhores cumprimentos,\nO nosso maior valor é a vida.";

            // Define o assunto do e-mail
            $assunto = "Marcação de Consulta";

            // Cria uma instância do controlador de e-mail
            $emailController = new EmailController();

            // Cria uma requisição simulada
            $requestEmail = Request::create('/send-email', 'POST', [
                'toEmail' => $paciente->email,
                'message' => $mensagem,
                'subject' => $assunto
            ]);

            // Chama o método sendEmail e obtém a resposta
            $response = $emailController->sendEmail($requestEmail);

            // Processa a resposta
            if ($response->status() == 200) {
                return back()->with(['success' => 'Consulta marcada e e-mail enviado com sucesso!']);
            } else {
                $responseData = $response->json();
                return back()->with(['error' => $responseData['message']])->withInput();
            }

        } catch (\Exception $e) {
            // Redireciona de volta com a mensagem de erro em caso de exceção
            return back()->with(['error' => 'Erro ao criar agendamento: ' . $e->getMessage()])->withInput();
        }
    }

    private function validateRequest(Request $request)
    {
        $validPaymentOptions = FormaPagamentoEnum::getValues();

        Log::info('Dados recebidos para agendamento: ', $request->all());

        // Validação dos campos
        $validatedData = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'dia' => 'required|date_format:d/m/Y',
            'horario' => 'required|date_format:H:i',
            'disponibilidade_id' => 'required|exists:disponibilidades,id',
            'forma_pagamento' => 'nullable|in:' . implode(',', $validPaymentOptions),
            'cartao_seguro_saude' => 'nullable|file|mimes:pdf,jpeg,png',
        ]);

        // Verifica se o paciente está selecionado e a forma de pagamento
        $paciente = Paciente::find($validatedData['paciente_id']);
        if (!$paciente) {
            throw new \Exception('Paciente não encontrado.');
        }



        $this->checkFormaPagamento($validatedData['forma_pagamento'], $paciente);

        return $validatedData;
    }

    private function checkFormaPagamento($formaPagamento, $paciente)
    {
        if ($formaPagamento == 'Via Seguro de Saude' && !$paciente->cartao_seguro_saude) {
            return 'O Paciente nao fez upload do cartao seguro saude e é obrigatório para "Via Seguro de Saude".';
        }

        if ($formaPagamento == 'Via Empresa' && !$paciente->empresa) {
            return 'O Paciente nao possui uma empresa cadastrada e é obrigatório para "Via Empresa".';
        }

        return null;
    }


    private function createAgendamento(array $data)
    {
        try {
            $data['dia'] = Carbon::createFromFormat('d/m/Y', $data['dia'])->format('Y-m-d');
            $data['horario'] = Carbon::createFromFormat('H:i', $data['horario'])->format('H:i:s');
            $data['forma_pagamento'] = FormaPagamentoEnum::from($data['forma_pagamento'])->value;

            Log::info('Data convertida: ' . $data['dia']);
            Log::info('Horário convertido: ' . $data['horario']);

            $agendamento = Agendamento::create([
                'dia' => $data['dia'],
                'paciente_id' => $data['paciente_id'],
                'horario' => $data['horario'],
                'forma_pagamento' => $data['forma_pagamento'],
            ]);

            Log::info('Agendamento criado com sucesso.', ['agendamento_id' => $agendamento->id, 'horario' => $agendamento->horario]);

            return $agendamento;
        } catch (\Exception $e) {
            Log::error('Erro ao criar agendamento: ' . $e->getMessage());
            throw $e;
        }
    }

    private function associateDisponibilidade(Agendamento $agendamento, $disponibilidadeId)
    {
        if ($disponibilidadeId) {
            $agendamento->disponibilidades()->attach($disponibilidadeId);
            Log::info('Associação com a tabela pivot realizada com sucesso.', [
                'agendamento_id' => $agendamento->id,
                'disponibilidade_id' => $disponibilidadeId,
            ]);
        } else {
            Log::warning('Nenhuma disponibilidade selecionada para associar ao agendamento.');
        }
    }

    private function processarUploadCartao(Request $request, Agendamento $agendamento)
    {
        if ($request->hasFile('cartao_seguro_saude')) {
            $pathPrincipal = storage_path('app/public/consultas/cartao_saude');
            $originalFileName = $request->file('cartao_seguro_saude')->getClientOriginalName();
            $paciente = Paciente::find($request->input('paciente_id'));
            $nomePaciente = $paciente->nome;
            $dataConsulta = $request->input('dia');
            $horaInicio = $request->input('horario');
            $nomeArquivo = "{$nomePaciente}_{$dataConsulta}_{$horaInicio}_{$originalFileName}";

            $request->file('cartao_seguro_saude')->storeAs('public/consultas/cartao_saude', $nomeArquivo);

            $agendamento->update(['cartao_seguro_saude' => $nomeArquivo]);
        }
    }

    public function show($id)
    {
        // Carrega o agendamento com paciente, disponibilidades, médico, especialidade e consulta relacionada
        $agendamento = Agendamento::with([
            'paciente',
            'disponibilidades.medico.especialidade',
            'consulta.medico',
            'consulta.paciente',
            'consulta.diagnostico',
            'consulta.prescricao'
        ])->findOrFail($id);

        // Passa o agendamento e a consulta com todos os relacionamentos carregados para a view
        return view('agendamentos.view', [
            'agendamento' => $agendamento,
            'consulta' => $agendamento->consulta,
            'diagnostico' => $agendamento->consulta ? $agendamento->consulta->diagnostico : null,
            'prescricao' => $agendamento->consulta ? $agendamento->consulta->prescricao : null,
        ]);
    }
}

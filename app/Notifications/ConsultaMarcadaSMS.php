<?php

namespace App\Notifications;


use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

use Twilio\Rest\Client;

class ConsultaMarcadaSMS extends Notification implements ShouldQueue
{
    protected $consulta;

    public function __construct($consulta)
    {
        $this->consulta = $consulta;
    }

    public function via($notifiable)
    {
        return ['sms'];
    }

    public function toSms($notifiable)
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $from = config('services.twilio.from');
        $to = $notifiable->phone;

        $twilio = new Client($sid, $token);

        $message = $twilio->messages
            ->create($to, [
                "body" => "Olá {$this->consulta->paciente->nome}, sua consulta foi marcada com sucesso. Abaixo estão os detalhes:\n\nData da Consulta: {$this->consulta->data_consulta}\nHora de Início: {$this->consulta->hora_inicio}\nHora de Fim: {$this->consulta->hora_fim}\nMédico: {$this->consulta->medico->nome}\nObservações: {$this->consulta->observacoes}\n\nObrigado por usar nosso serviço!",
                "from" => $from,
            ]);

        return $message->sid;
    }
}

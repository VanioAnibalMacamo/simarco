<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Aloha\Twilio\Twilio;

class ConsultaMarcadaSMS extends Notification implements ShouldQueue
{
    use Queueable;

    protected $consulta;

    /**
     * Create a new notification instance.
     *
     * @param mixed $consulta
     */
    public function __construct($consulta)
    {
        $this->consulta = $consulta;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array<string>
     */
    public function via($notifiable)
    {
        return ['sms']; // Alterado para 'sms' para indicar o canal SMS
    }

    /**
     * Get the Twilio representation of the notification.
     *
     * @param mixed $notifiable
     * @return TwilioMessage
     */
    public function toSms($notifiable)
    {
        $twilio = new Twilio(
            config('services.twilio.sid'),
            config('services.twilio.token'),
            config('services.twilio.from')
        );

        $message = "Olá {$this->consulta->paciente->nome}, sua consulta foi marcada com sucesso. Abaixo estão os detalhes:\n\nData da Consulta: {$this->consulta->data_consulta}\nHora de Início: {$this->consulta->hora_inicio}\nHora de Fim: {$this->consulta->hora_fim}\nMédico: {$this->consulta->medico->nome}\nObservações: {$this->consulta->observacoes}\n\nObrigado por usar nosso serviço!";

        return $twilio->message($notifiable->phone, $message);
    }
}

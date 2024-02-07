<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Consulta;

class ConsultaMarcadaMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $consulta;

    /**
     * Create a new message instance.
     *
     * @param Consulta $consulta
     */
    public function __construct(Consulta $consulta)
    {
        $this->consulta = $consulta;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Consulta Marcada')
            ->view('emails.consulta_marcada')
            ->with([
                'consulta' => $this->consulta,
            ]);
    }
}

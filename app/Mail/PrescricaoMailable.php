<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PrescricaoMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $prescricao;
    public $paciente;
    public $consulta;  // Adiciona a consulta
    public $pdfPath;

    /**
     * Create a new message instance.
     *
     * @param $prescricao
     * @param $paciente
     * @param $consulta  // Adiciona a consulta
     * @param $pdfPath
     */
    public function __construct($prescricao, $paciente, $consulta, $pdfPath)
    {
        $this->prescricao = $prescricao;
        $this->paciente = $paciente;
        $this->consulta = $consulta;  // Inicializa a consulta
        $this->pdfPath = $pdfPath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $dataPrescricao = \Carbon\Carbon::parse($this->prescricao->data_prescricao)->format('d-m-Y');
        $nomePaciente = preg_replace('/[^a-zA-Z0-9]/', '_', $this->paciente->nome);
        $nomeArquivo = "Prescricao_Consulta_{$dataPrescricao}_{$nomePaciente}.pdf";
        
        return $this->view('emails.prescricao')
                    ->subject('Prescrição Médica')
                    ->attach($this->pdfPath, [
                        'as' => $nomeArquivo,
                        'mime' => 'application/pdf',
                    ]);
    }
}

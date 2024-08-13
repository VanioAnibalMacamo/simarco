<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Email;

class EmailController extends Controller
{
    //

    public function sendEmail(Request $request)
    {
        // Receber os parâmetros do JSON no corpo da requisição
        $toEmail = $request->input('toEmail');
        $message = $request->input('message');
        $subject = $request->input('subject');

        try {
            Mail::to($toEmail)->send(new Email($message, $subject));

            return response()->json([
                'status' => 'success',
                'message' => 'Email enviado com sucesso!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Falha ao enviar o email.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function testEmail(Request $request)
    {
        $toEmail = $request->query('toEmail');
        $message = $request->query('message');
        $subject = $request->query('subject');

        // Chamar o método sendEmail e retornar a resposta como JSON
        return $this->sendEmail($toEmail, $message, $subject);
    }

}

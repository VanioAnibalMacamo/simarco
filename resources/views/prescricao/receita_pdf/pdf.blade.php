<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Prescrição Médica</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #f4f4f4;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            border-bottom: 2px solid #0044cc;
            padding-bottom: 10px;
            margin-bottom: 20px;
            position: relative;
        }
        .header img {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 100px;
            height: auto;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #0044cc;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h2 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #0044cc;
        }
        .section p {
            font-size: 16px;
            line-height: 1.5;
        }
        .medicamentos {
            margin-top: 20px;
        }
        .medicamento {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fafafa;
        }
        .medicamento h3 {
            margin: 0 0 5px;
            font-size: 18px;
            color: #0044cc;
        }
        .medicamento p {
            margin: 5px 0;
            font-size: 16px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">

            <h1>CLINICARE</h1>
            <h2>Prescrição Médica</h2>
        </div>

        <div class="section">
            <p><strong>Data da Prescrição:</strong> {{ \Carbon\Carbon::parse($prescricao->data_prescricao)->format('d/m/Y') }}</p>
            <p><strong>Paciente:</strong> {{ $paciente->nome }}</p>
            <p><strong>Médico Responsável:</strong> {{ $consulta->medico->nome }}</p>
            <p><strong>Data e Hora da Consulta:</strong> {{ \Carbon\Carbon::parse($consulta->data_consulta)->format('d/m/Y') }} às {{ \Carbon\Carbon::parse($consulta->hora_inicio)->format('H:i') }}</p>
        </div>

        <div class="medicamentos">
            <h2>Medicamentos Prescritos</h2>
            @foreach ($medicamentos as $medicamento)
                <div class="medicamento">
                    <h3>{{ $medicamento->nome_medicamento }}</h3>
                    <p><strong>Dosagem:</strong> {{ $medicamento->pivot->dosagem }}</p>
                    <p><strong>Instruções:</strong> {{ $medicamento->pivot->instrucoes }}</p>
                </div>
            @endforeach
        </div>

        <div class="footer">
            <p>Obrigado por confiar em nossos serviços.</p>
            <p>Para mais informações, entre em contato conosco pelo e-mail: <a href="mailto:simarco.system@gmail.com">simarco.system@gmail.com</a></p>
        </div>
    </div>
</body>
</html>

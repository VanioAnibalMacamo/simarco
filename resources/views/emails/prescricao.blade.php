<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescrição Médica</title>
</head>

<body>
    <h2>Prescrição Médica</h2>

    <p>Prezado(a) {{ $paciente->nome }},</p>

    <p>
        Em anexo, você encontrará a prescrição médica da consulta realizada no dia
        {{ \Carbon\Carbon::parse($consulta->data_consulta)->format('d/m/Y') }} às
        {{ \Carbon\Carbon::parse($consulta->hora_inicio)->format('H:i') }} com o(a) Dr(a).
        {{ $consulta->medico->nome }}.
    </p>

    <p>Obrigado por usar nossos serviços!</p>
</body>

</html>

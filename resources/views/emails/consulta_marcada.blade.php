<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta Marcada</title>
</head>

<body>
    <h2>Consulta Marcada</h2>
    <p>Olá {{ $consulta->paciente->nome }},</p>
    <p>Sua consulta foi marcada com sucesso. Abaixo estão os detalhes:</p>
    <ul>
        <li><strong>Data da Consulta:</strong> {{ $consulta->data_consulta }}</li>
        <li><strong>Hora de Início:</strong> {{ $consulta->hora_inicio }}</li>
        <li><strong>Hora de Fim:</strong> {{ $consulta->hora_fim }}</li>
        <li><strong>Médico:</strong> {{ $consulta->medico->nome }}</li>
        <li><strong>Observações:</strong> {{ $consulta->observacoes }}</li>
    </ul>
    <p>Obrigado por usar nosso serviço!</p>
</body>

</html>

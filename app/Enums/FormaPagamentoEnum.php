<?php

namespace App\Enums;

enum FormaPagamentoEnum: string
{
    case TRANSFERENCIA_BANCARIA = 'Transferencia Bancaria';
    case APOLICE = 'Apolice';
    case CARTEIRAS_MOVEIS = 'Carteiras Moveis';

    public static function getValues(): array
    {
        return array_map(fn($enum) => $enum->value, self::cases());
    }
}

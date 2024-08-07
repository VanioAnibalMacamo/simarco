<?php

namespace App\Enums;

enum FormaPagamentoEnum: string
{
    case CASH = 'Cash';
    case SEGURO = 'Via Seguro de Saúde';
    case EMPRESA = 'Via Empresa';

    public static function getValues(): array
    {
        return array_map(fn($enum) => $enum->value, self::cases());
    }
}



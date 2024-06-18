<?php

namespace App\Enums;


final class FormaPagamentoEnum
{
    const CASH = 'Cash';
    const VIA_SEGURO_DE_SAUDE = 'Via Seguro de Saúde';
    const VIA_EMPRESA = 'Via Empresa';

    public static function getConstants()
    {
        $reflectionClass = new \ReflectionClass(self::class);
        return $reflectionClass->getConstants();
    }
}

<?php

namespace App\Enums;

class DisponibilidadeEnum
{
    const DISPONIVEL = 'disponivel';
    const INDISPONIVEL = 'indisponivel';
    const DE_FERIAS = 'de_ferias';
    const EM_ATENDIMENTO = 'em_atendimento';

    public static function getConstants()
    {
        $reflectionClass = new \ReflectionClass(self::class);
        return $reflectionClass->getConstants();
    }
}

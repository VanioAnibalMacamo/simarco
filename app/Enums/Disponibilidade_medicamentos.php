<?php

namespace App\Enums;

class Disponibilidade_medicamentos
{
    const DISPONIVEL = 'disponivel';
    const INDISPONIVEL = 'indisponivel';


    public static function getConstants()
    {
        $reflectionClass = new \ReflectionClass(self::class);
        return $reflectionClass->getConstants();
    }
}

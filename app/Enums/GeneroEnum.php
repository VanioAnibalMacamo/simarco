<?php

namespace App\Enums;

class GeneroEnum
{
    const MASCULINO = 'masculino';
    const FEMININO = 'feminino';

    public static function getConstants()
    {
        $reflectionClass = new \ReflectionClass(self::class);
        return $reflectionClass->getConstants();
    }
}

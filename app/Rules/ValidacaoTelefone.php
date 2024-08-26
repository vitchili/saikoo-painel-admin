<?php

namespace App\Rules;

use Exception;

class ValidacaoTelefone
{
    public static function transformarApenasNumeros(mixed $value): int
    {
       return preg_replace('/\D/', '', $value);
    }
}

<?php 

namespace App\Rules;

class ContemCaractereEspecial
{
    public function validar($value)
    {
        return preg_match('/[!@#$%^&*(),.?":{}|<>]/', $value) === 1;
    }

    public function message()
    {
        return 'A :attribute deve conter pelo menos um caractere especial.';
    }
}

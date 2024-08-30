<?php

namespace App\Rules;

use Exception;

class ValidacaoCpfCnpj
{
    public const CPF = 1;
    public const CNPJ = 2;

    public function validar(mixed $value): void
    {
        $validaCpf = $this->validaCpf($value);
        $validaCnpj = $this->validaCnpj($value);

        if(! $validaCpf && !$validaCnpj){
            throw new Exception("O CPF/CNPJ '{$value}' é inválido");
        }
    }

    public function validaCpf($value): bool
    {
        $c = preg_replace('/\D/', '', $value);

        if (strlen($c) != 11 || preg_match("/^{$c[0]}{11}$/", $c)) {
            return false;
        }

        for ($s = 10, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--);

        if ($c[9] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        for ($s = 11, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--);

        if ($c[10] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        return true;
    }

    public function validaCnpj($value): bool
    {
        $c = preg_replace('/\D/', '', $value);

        $b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        if (strlen($c) != 14) {
            return false;

        }

        elseif (preg_match("/^{$c[0]}{14}$/", $c) > 0) {

            return false;
        }

        for ($i = 0, $n = 0; $i < 12; $n += $c[$i] * $b[++$i]);

        if ($c[12] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        for ($i = 0, $n = 0; $i <= 12; $n += $c[$i] * $b[$i++]);

        if ($c[13] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        return true;
    }
    
    public static function transformarApenasNumeros(mixed $value): string
    {
       return strval(preg_replace('/\D/', '', $value));
    }

    public static function cpfOuCnpj(mixed $value): string
    {
        if (strlen(self::transformarApenasNumeros($value)) == 11) {
            return self::CPF;
        }

        if (strlen(self::transformarApenasNumeros($value)) == 14) {
            return self::CNPJ;
        }

        return (int) false;
    }

}

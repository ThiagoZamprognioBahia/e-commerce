<?php namespace App\Utils;

use App\Traits\ValidacoesTrait;

class CnpjValidation
{
    use ValidacoesTrait;

    public function validate($attribute, $value, $parameters, $validator)
    {
        return $this->validarCNPJ($value);
    }
}

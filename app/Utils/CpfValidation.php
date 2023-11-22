<?php namespace App\Utils;

use App\Traits\ValidacoesTrait;

class CpfValidation
{
    use ValidacoesTrait;

    public function validate($attribute, $value, $parameters, $validator)
    {
        return $this->validarCPF($value);
    }
}

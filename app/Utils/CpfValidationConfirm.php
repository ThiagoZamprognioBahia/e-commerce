<?php namespace App\Utils;

use App\Models\Cliente;

class CpfValidationConfirm
{

    public function validate($attribute, $value, $parameters, $validator)
    {
        return  !Cliente::query()
            ->where('cpf', $value)
            ->exists();
    }
}

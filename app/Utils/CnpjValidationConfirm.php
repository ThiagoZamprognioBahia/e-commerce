<?php namespace App\Utils;

use App\Models\Cliente;

class CnpjValidationConfirm
{

    public function validate($attribute, $value, $parameters, $validator)
    {
        return  !Cliente::query()
            ->where('cnpj', $value)
            ->exists();
    }
}

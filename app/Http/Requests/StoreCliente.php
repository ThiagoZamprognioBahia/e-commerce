<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCliente extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome'            => 'required|string',
            'sobrenome'       => 'required|string',
            'tipo_pessoa'     => 'required|string|in:F,J,E',
            'data_nascimento' => 'required|date_format:Y-m-d',
            'cpf'             => 'nullable|string|cpf|cpfConfirm',
            'cnpj'            => 'nullable|string|cnpj|cnpjConfirm',
            'telefone'        => 'nullable|string',
            'email'           => 'required|string|email|unique:clientes,email',
            'senha'           => 'required|string|min:8',
        ];
    }

    public function messages()
    {
        return [
            'cpf.unique'   => 'O CPF inserido já pertence a uma pessoa',
            'cnpj.unique'  => 'O CNPJ inserido já pertence a uma empresa',
            'email.unique' => 'O e-mail inserido já pertence a uma pessoa',     
        ];
    }
}

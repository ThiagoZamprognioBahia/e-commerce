<?php

namespace App\Traits;

trait ValidacoesTrait
{
    public function validarCPF($cpf)
    {
        // Extrair somente os números
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        // Validações básicas
        if ($cpf == null || !is_numeric($cpf) || strlen($cpf) !== 11) {
            return false;
        }

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    /**
     * Esta função testa se um CNPJ é valido ou não.
     *
     * @param   string   $cnpj  Guarda o CNPJ como ele foi digitado pelo cliente.
     * @return  boolean         "true" se o CNPJ é válido ou "false" caso o contrário.
     */
    public function validarCNPJ($cnpj)
    {
        // Remove a pontuação e caracteres especiais do CNPJ.
        $cnpj = preg_replace('/[^0-9]/is', '', $cnpj);

        // Validações báscias.
        if ($cnpj == null || !is_numeric($cnpj) || strlen($cnpj) !== 14) {
            return false;
        }

        // Cria um array com apenas os digitos numéricos, isso permite receber
        // o CNPJ em diferentes formatos como "00.000.000/0000-00",
        // "00000000000000", "00 000 000 0000 00" etc.
        $cnpj = str_split($cnpj);

        // Conta os dígitos, um CNPJ válido possui 14 dígitos numéricos.
        if (count($cnpj) != 14) {
            return false;
        }

        // Calcula e compara o primeiro dígito verificador.
        $j = 5;
        for ($i = 0; $i < 4; $i++) {
            $multiplica[$i] = $cnpj[$i] * $j;
            $j--;
        }

        $soma = array_sum($multiplica);
        $j    = 9;
        for ($i = 4; $i < 12; $i++) {
            $multiplica[$i] = $cnpj[$i] * $j;
            $j--;
        }

        $soma  = array_sum($multiplica);
        $resto = $soma % 11;
        if ($resto < 2) {
            $dg = 0;
        } else {
            $dg = 11 - $resto;
        }

        if ($dg != $cnpj[12]) {
            return false;
        }

        // Calcula e compara o segundo dígito verificador.
        $j = 6;
        for ($i = 0; $i < 5; $i++) {
            $multiplica[$i] = $cnpj[$i] * $j;
            $j--;
        }

        $soma = array_sum($multiplica);
        $j    = 9;
        for ($i = 5; $i < 13; $i++) {
            $multiplica[$i] = $cnpj[$i] * $j;
            $j--;
        }

        $soma  = array_sum($multiplica);
        $resto = $soma % 11;
        if ($resto < 2) {
            $dg = 0;
        } else {
            $dg = 11 - $resto;
        }

        if ($dg != $cnpj[13]) {
            return false;
        }

        return true;
    }
}

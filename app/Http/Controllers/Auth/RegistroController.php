<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCliente;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller
{
    public function store(StoreCliente $request)
    {

        $dadosValidados = $request->validated();

        try {
            DB::beginTransaction();
            $cliente        = Cliente::make($dadosValidados);
            $cliente->senha = Hash::make($dadosValidados['senha']);
            $cliente->save();

            $token = $cliente->createToken('TokenName')->plainTextToken;

            DB::commit();
            return response()->json([
                'message' => 'Usuário criado com sucesso',
                'token'   => $token,
                'dados'   => $cliente,
            ], 201); 
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar o usuário'], 500);
        }
    }

}

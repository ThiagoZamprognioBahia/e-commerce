<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegistroAdminController extends Controller
{
    public function store(Request $request)
    {
        $dadosValidados = $request->validate([
            'nome'  => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'senha' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $usuario        = User::make($dadosValidados);
            $usuario->senha = Hash::make($dadosValidados['senha']);
            $usuario->save();

            $token = $usuario->createToken('TokenName')->plainTextToken;

            DB::commit();
            return response()->json([
                'message' => 'Usuário criado com sucesso',
                'token'   => $token,
                'dados'   => $usuario,
            ], 201); 
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar o usuário'], 500);
        }
    }

}

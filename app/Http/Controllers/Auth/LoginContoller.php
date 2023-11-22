<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
class LoginContoller extends Controller
{
    public function login(Request $request)
    {
        $dadosValidados = $request->validate([
            'email'       => 'required|email',
            'senha'       => 'required|string',
        ]);

        $cliente = Cliente::where('email', $dadosValidados['email'])->first();

        // Verifica se o usuário existe e a senha está correta
        if (!$cliente || !Hash::check($dadosValidados['senha'], $cliente->senha)) {
            throw ValidationException::withMessages([
                'message' => ['E-mail ou senha estão errados'],
            ]);
        }

        // Revoga todos os tokens do usuário
        $cliente->tokens()->delete();

        // Cria um novo token de acesso
        $token = $cliente->createToken('TokenName')->plainTextToken;

        return response()->json([
            'message'   => 'Autenticação bem-sucedida',
            'token'     => $token,
        ]);
    }
}
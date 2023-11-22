<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function auth(Request $request)
    {
        $dadosValidados = $request->validate([
            'email' => 'required|email',
            'senha' => 'required',
        ]);

        $usuario = User::where('email', $dadosValidados['email'])->first();

        // Verifica se o usuário existe e a senha está correta
        if (!$usuario || !Hash::check($dadosValidados['senha'], $usuario->senha)) {
            throw ValidationException::withMessages([
                'message' => ['E-mail ou senha estão errados'],
            ]);
        }

        // Revoga todos os tokens do usuário
        $usuario->tokens()->delete();

        // Cria um novo token de acesso
        $token = $usuario->createToken('TokenName')->plainTextToken;

        return response()->json([
            'message'   => 'Autenticação bem-sucedida',
            'token'     => $token,
        ]);
    }
}

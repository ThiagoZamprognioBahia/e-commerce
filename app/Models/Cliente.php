<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Cliente extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nome',
        'sobrenome',
        'tipo_pessoa',
        'data_nascimento',
        'cpf',
        'cnpj',
        'telefone',
        'email',
        'senha',
        'bairro',
        'cidade',
        'cep',
        'rua',
        'numero',
        'complemento',
        'url_imagem',
    ];

    protected $hidden = [
        'senha',
        'remember_token',
    ];
}

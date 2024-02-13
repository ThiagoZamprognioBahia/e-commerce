<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class produto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'referencia',
        'descricao',
        'valor',
        'valor_riscado',
        'estoque',
        'status',
        'ncm',
        'altura',
        'largura',
        'comprimento',
        'peso',
        'acessos',
        'departamento_id',
        'categoria_id',
        'sub_categoria_id',
    ];
}


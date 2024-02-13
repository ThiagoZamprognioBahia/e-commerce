<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProdutoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'               => $this->id,
            'nome'             => $this->nome,
            'referencia'       => $this->referencia,
            'descricao'        => $this->descricao,
            'valor'            => $this->valor,
            'valor_riscado'    => $this->valor_riscado,
            'estoque'          => $this->estoque,
            'status'           => $this->status,
            'ncm'              => $this->ncm,
            'altura'           => $this->altura,
            'largura'          => $this->largura,
            'comprimento'      => $this->comprimento,
            'peso'             => $this->nopesome,
            'acessos'          => $this->acessos,
            'departamento_id'  => $this->departamento_id,
            'categoria_id'     => $this->categoria_id,
            'sub_categoria_id' => $this->sub_categoria_id,
        ];
    }
}

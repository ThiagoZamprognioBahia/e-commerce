<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartamentoResource extends JsonResource
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
            'id'                 => $this->id,
            'nome'               => $this->nome,
            'descricao'          => $this->descricao,
            'status'             => $this->status,
            'acessos'            => $this->acessos,
            'ordem_Departamento' => $this->ordem_Departamento,
        ];
    }
}

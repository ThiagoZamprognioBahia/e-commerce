<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoriaResource extends JsonResource
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
            'id'              => $this->id,
            'departamento_id' => $this->departamento_id,
            'nome'            => $this->nome,
            'status'          => $this->status,
            'acessos'         => $this->acessos,
            'ordem_categoria' => $this->ordem_categoria,
        ];
    }
}

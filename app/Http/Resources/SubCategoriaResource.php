<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoriaResource extends JsonResource
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
            'id'                  => $this->id,
            'categoria_id'        => $this->categoria_id,
            'nome'                => $this->nome,
            'status'              => $this->status,
            'acessos'             => $this->acessos,
            'ordem_sub_categoria' => $this->ordem_sub_categoria,
        ];
    }
}

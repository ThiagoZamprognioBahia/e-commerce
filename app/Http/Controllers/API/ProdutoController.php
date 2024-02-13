<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProdutoResource;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdutoController extends Controller
{
    public function index()
    {
        $produto = Produto::where('status', 1)
        ->get();

        return ProdutoResource::collection($produto);
    }

    public function store(Request $request)
    {
        $dadosValidados = $request->validate([
            'nome'             => 'required|string',
            'descricao'        => 'required|string',
            'referencia'       => 'required|string',
            'valor'            => 'required|numeric',
            'valor_riscado'    => 'nullable|numeric',
            'estoque'          => 'required|integer',
            'ncm'              => 'nullable|integer',
            'altura'           => 'nullable|numeric',
            'largura'          => 'nullable|numeric',
            'comprimento'      => 'nullable|numeric',
            'peso'             => 'nullable|numeric',
            'departamento_id'  => 'required|integer',
            'categoria_id'     => 'required|integer',
            'sub_categoria_id' => 'required|integer',
        ]);

        $produto = Produto::where('referencia', $dadosValidados['referencia'])->first();

        if($produto){
            return response()->json(['message' => 'Essa referência já está cadastrada no sistema'], 422);
        }

        try {
            DB::beginTransaction();
            $produto = Produto::create($dadosValidados);
            

            return response()->json([
                'message' => 'Produto criado com sucesso',
                'dados'   => $produto,
            ], 201); 
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar o produto'], 500);
        }

    }

    public function show($id)
    {
        $produto = Produto::findOrFail($id);

        return ProdutoResource::make($produto);
    }

    public function update($id, Request $request)
    {
        $dadosValidados = $request->validate([
            'nome'             => 'required|string',
            'descricao'        => 'required|string',
            'referencia'       => 'required|string',
            'valor'            => 'required|numeric',
            'status'           => 'nullable|boolean',
            'valor_riscado'    => 'nullable|numeric',
            'estoque'          => 'required|integer',
            'ncm'              => 'nullable|integer',
            'altura'           => 'nullable|numeric',
            'largura'          => 'nullable|numeric',
            'comprimento'      => 'nullable|numeric',
            'peso'             => 'nullable|numeric',
            'departamento_id'  => 'required|integer',
            'categoria_id'     => 'required|integer',
            'sub_categoria_id' => 'required|integer',
        ]);

        $produto = Produto::where('referencia', $dadosValidados['referencia'])
            ->where('id', '!=', $id)
            ->first();

        if($produto){
            return response()->json(['message' => 'Essa referência já está cadastrada no sistema'], 422);
        }

        $produto = Produto::findOrFail($id);
        $produto->update($dadosValidados);

        return response()->json([
            'message' => 'Produto atualizado com sucesso',
            'dados'   => $produto,
        ], 201); 
    }

    public function destroy($id)
    {
        $produto = Produto::findOrFail($id);

        $produto->status = 0;
        $produto->save();
        $produto->delete();

        return response()->json([
            'message' => 'O Produto foi desativado com sucesso',
        ], 201); 
    }

}

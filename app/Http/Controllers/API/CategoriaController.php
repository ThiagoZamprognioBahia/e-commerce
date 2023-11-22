<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\categoriaResource;
use App\Models\categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class categoriaController extends Controller
{
    public function index(Request $request)
    {
        $query = Categoria::query();
        $query->where('status', 1);

        if ($request->has('departamento_id') && $request->input('departamento_id')) {
            $query->where('departamento_id', $request->departamento_id);
        }
            
        $categorias = $query->orderBy('ordem_categoria', 'ASC')
        ->get();

        return categoriaResource::collection($categorias);
    }

    public function store(Request $request)
    {
        $dadosValidados = $request->validate([
            'departamento_id' => 'required|integer',
            'nome'            => 'required|string',
        ]);

        try {
            DB::beginTransaction();
            $categoria = Categoria::make($dadosValidados);
            $categoria->ordem_categoria = (Categoria::max('ordem_categoria') + 1);
            $categoria->save();
            

            return response()->json([
                'message' => 'categoria criada com sucesso',
                'dados'   => $categoria,
            ], 201); 
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar a categoria'], 500);
        }

    }

    public function show($id)
    {
        $categoria = Categoria::findOrFail($id);

        return categoriaResource::make($categoria);
    }

    public function update($id, Request $request)
    {
        $dadosValidados = $request->validate([
            'departamento_id' => 'nullable|integer',
            'nome'            => 'nullable|string',
            'status'          => 'nullable|boolean'
        ]);

        $categoria = Categoria::findOrFail($id);
        $categoria->update($dadosValidados);

        return response()->json([
            'message' => 'Categoria atualizada com sucesso',
            'dados'   => $categoria,
        ], 201); 
    }

    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);

        $categoria->status = 0;
        $categoria->save();
        $categoria->delete();

        return response()->json([
            'message' => 'A categoria foi desativada e não removida',
        ], 201); 
    }

    //função será implementada no futuro como uma feature
    // public function mudarOrdem(Request $request)
    // {
    //     $dadosValidados = $request->validate([
    //         'id'                 => 'required|string',
    //         'ordem_categoria' => 'required|string',
    //     ]);

    //     DB::beginTransaction();
    //     foreach ($dadosValidados as $dado){
    //         categoria::where('id', $dado->id)->update($request->only(['ordem_categoria']));
    //     }
    //     DB::commit();

    //    $categorias = categoria::where('status', 1)
    //     ->orderBy('ordem_categoria', 'ASC')
    //     ->get();

    //     return categoriaResource::collection($categorias);
    // possivel rota a baixo
    // Route::post('/categoria/mudar-ordem', [categoriaController::class, 'mudarOrdem']);
    // }
}

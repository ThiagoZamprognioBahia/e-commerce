<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\SubCategoriaResource;
use App\Models\SubCategoria;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class SubCategoriaController extends Controller
{
    
    public function index(Request $request)
    {
        $query = SubCategoria::query();
        $query->where('status', 1);

            if ($request->has('categoria_id') && $request->input('categoria_id')) {
                $query->where('categoria_id', $request->categoria_id);
            }
        $subCategorias = $query->orderBy('ordem_sub_categoria', 'ASC')
        ->get();

        return SubCategoriaResource::collection($subCategorias);
    }

    public function store(Request $request)
    {
        $dadosValidados = $request->validate([
            'categoria_id' => 'required|integer',
            'nome'         => 'required|string',
        ]);

        try {
            DB::beginTransaction();
            $subCategoria = SubCategoria::make($dadosValidados);
            $subCategoria->ordem_sub_categoria = (SubCategoria::max('ordem_sub_categoria') + 1);
            $subCategoria->save();
            

            return response()->json([
                'message' => 'Sub categoria criada com sucesso',
                'dados'   => $subCategoria,
            ], 201); 
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar a sub categoria'], 500);
        }

    }

    public function show($id)
    {
        $subCategoria = SubCategoria::findOrFail($id);

        return SubCategoriaResource::make($subCategoria);
    }

    public function update($id, Request $request)
    {
        $dadosValidados = $request->validate([
            'categoria_id' => 'nullable|integer',
            'nome'         => 'nullable|string',
            'status'       => 'nullable|boolean'
        ]);

        $subCategoria = SubCategoria::findOrFail($id);
        $subCategoria->update($dadosValidados);

        return response()->json([
            'message' => 'Sub categoria atualizada com sucesso',
            'dados'   => $subCategoria,
        ], 201); 
    }

    public function destroy($id)
    {
        $subCategoria = SubCategoria::findOrFail($id);

        $subCategoria->status = 0;
        $subCategoria->save();
        $subCategoria->delete();

        return response()->json([
            'message' => 'A sub categoria foi desativada e não removida',
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

    //    $subCategorias = categoria::where('status', 1)
    //     ->orderBy('ordem_categoria', 'ASC')
    //     ->get();

    //     return categoriaResource::collection($subCategorias);
    // possivel rota a baixo
    // Route::post('/categoria/mudar-ordem', [categoriaController::class, 'mudarOrdem']);
    // }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\DepartamentoResource;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartamentoController extends Controller
{
    public function index()
    {
        $departamentos = Departamento::where('status', 1)
        ->orderBy('ordem_Departamento', 'ASC')
        ->get();

        return DepartamentoResource::collection($departamentos);
    }

    public function store(Request $request)
    {
        $dadosValidados = $request->validate([
            'nome'      => 'required|string',
            'descricao' => 'required|string',
        ]);

        try {
            DB::beginTransaction();
            $departamento = Departamento::make($dadosValidados);
            $departamento->ordem_Departamento = (Departamento::max('ordem_Departamento') + 1);
            $departamento->save();
            

            return response()->json([
                'message' => 'Departamento criado com sucesso',
                'dados'   => $departamento,
            ], 201); 
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar o departamento'], 500);
        }

    }

    public function show($id)
    {
        $departamento = Departamento::findOrFail($id);

        return DepartamentoResource::make($departamento);
    }

    public function update($id, Request $request)
    {
        $dadosValidados = $request->validate([
            'nome'      => 'nullable|string',
            'descricao' => 'nullable|string',
            'status'    => 'nullable|boolean'
        ]);

        $departamento = Departamento::findOrFail($id);
        $departamento->update($dadosValidados);

        return response()->json([
            'message' => 'Departamento atualizado com sucesso',
            'dados'   => $departamento,
        ], 201); 
    }

    public function destroy($id)
    {
        $departamento = Departamento::findOrFail($id);

        $departamento->status = 0;
        $departamento->save();
        $departamento->delete();

        return response()->json([
            'message' => 'O departamento foi desativado e não removido',
        ], 201); 
    }

    //função será implementada no futuro como uma feature
    // public function mudarOrdem(Request $request)
    // {
    //     $dadosValidados = $request->validate([
    //         'id'                 => 'required|string',
    //         'ordem_Departamento' => 'required|string',
    //     ]);

    //     DB::beginTransaction();
    //     foreach ($dadosValidados as $dado){
    //         Departamento::where('id', $dado->id)->update($request->only(['ordem_Departamento']));
    //     }
    //     DB::commit();

    //    $departamentos = Departamento::where('status', 1)
    //     ->orderBy('ordem_Departamento', 'ASC')
    //     ->get();

    //     return DepartamentoResource::collection($departamentos);
    // possivel rota a baixo
    // Route::post('/departamento/mudar-ordem', [DepartamentoController::class, 'mudarOrdem']);
    // }
}

<?php

namespace App\Http\Controllers\API;

use App\Models\Entrada;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class EntradaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $entradas = Entrada::with(['producto', 'almacen'])->get();
        return response()->json($entradas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'lote' => 'nullable|string|unique:entradas|max:255',
            'cantidad' => 'required|integer',
            'fecha_vencimiento' => 'nullable|date',
            'almacen_id' => 'required',
            'producto_id' => 'required'
        ]);

        if (DB::table('almacens')->where('id', $request->almacen_id)->exists() && DB::table('productos')->where('id', $request->producto_id)->exists()) {
            $entrada = new Entrada;
            $entrada->lote = $request->lote;
            $entrada->cantidad = $request->cantidad;
            $entrada->fecha_vencimiento = $request->fecha_vencimiento;
            $entrada->almacen_id = $request->almacen_id;
            $entrada->producto_id = $request->producto_id;
            $entrada->save();
            return response()->json($entrada);
        } else {
            return response()->json(['message' => 'Almacén o Producto no registrado']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'lote' => ['nullable','string','max:255',Rule::unique('entradas')->ignore($id)],
            'cantidad' => 'required|integer',
            'fecha_vencimiento' => 'nullable|date',
            'almacen_id' => 'required',
            'producto_id' => 'required'
        ]);

        if (DB::table('almacens')->where('id', $request->almacen_id)->exists() && DB::table('productos')->where('id', $request->producto_id)->exists()) {
            $entrada = Entrada::findOrFail($id);
            $entrada->lote = $request->lote;
            $entrada->cantidad = $request->cantidad;
            $entrada->fecha_vencimiento = $request->fecha_vencimiento;
            $entrada->almacen_id = $request->almacen_id;
            $entrada->producto_id = $request->producto_id;
            $entrada->save();
            return response()->json($entrada);
        } else {
            return response()->json(['message' => 'Almacén o Producto no registrado']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $entrada = Entrada::findOrfail($id);
        $entrada->delete();
        return response()->json(['message' => 'Eliminado con exito']);
    }
}

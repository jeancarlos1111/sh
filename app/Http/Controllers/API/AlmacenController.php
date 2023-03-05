<?php

namespace App\Http\Controllers\API;

use App\Models\Institucion;
use App\Models\Almacen;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class AlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $almacenes = Almacen::with('institucion')->get();
        return response()->json($almacenes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nombre' => 'required|unique:almacens|max:255',
            'ubicacion' => 'required',
            'institucion_id' => 'required'
        ]);

        $almacen = new Almacen(['nombre' => $request->nombre, 'ubicacion' => $request->ubicacion]);

        $institucion = Institucion::findOrFail($request->institucion_id);
        $institucion->almacenes()->save($almacen);
        return response()->json($almacen);
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
            'nombre' => ['required','max:255',Rule::unique('almacens')->ignore($id)],
            'ubicacion' => 'required',
            'institucion_id' => 'required'
        ]);

        if (DB::table('institucions')->where('id', $request->institucion_id)->exists()) {
            $almacen = Almacen::findOrfail($id);
            $almacen->nombre = $request->nombre;
            $almacen->ubicacion = $request->ubicacion;
            $almacen->institucion_id = $request->institucion_id;
            $almacen->save();
            return response()->json($almacen);
        } else {
            return response()->json(['message' => 'La institución no esta registrada']);
        }
        
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $almacen = Almacen::findOrfail($id);
        $almacen->delete();
        return response()->json(['message' => 'Eliminado con exito']);
    }
}

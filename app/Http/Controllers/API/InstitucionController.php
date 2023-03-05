<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institucion;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class InstitucionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $instituciones = Institucion::all();
        return response()->json($instituciones);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nombre' => 'required|unique:institucions|max:255',
            'direccion' => 'required'
        ]);

        $institucion = Institucion::create(['nombre' => $request->nombre, 'direccion' => $request->direccion]);
        return response()->json($institucion);
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
            'nombre' => ['required','max:255',Rule::unique('institucions')->ignore($id)],
            'direccion' => 'required'
        ]);

        
        $institucion = Institucion::findOrfail($id);

        $institucion->nombre = $request->nombre;
        $institucion->direccion = $request->direccion;
        $institucion->save();
        return response()->json($institucion);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $institucion = Institucion::findOrfail($id);
        $institucion->delete();
        return response()->json(['message' => 'Eliminado con exito']);
    }
}

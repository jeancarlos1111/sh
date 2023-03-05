<?php

namespace App\Http\Controllers\API;

use App\Models\Producto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $productos = Producto::all();
        return response()->json($productos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nombre' => 'required|unique:productos|max:255',
            'descripcion' => 'required',
            'tipo_producto' => 'required|max:255'
        ]);

        $producto = Producto::create(['nombre' => $request->nombre, 'descripcion' => $request->descripcion, 'tipo_producto' => $request->tipo_producto]);
        return response()->json($producto);
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
            'nombre' => ['required','max:255',Rule::unique('productos')->ignore($id)],
            'descripcion' => 'required',
            'tipo_producto' => 'required|max:255'
        ]);

        
        $producto = Producto::findOrfail($id);

        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->tipo_producto = $request->tipo_producto;
        $producto->save();
        return response()->json($producto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $producto = Producto::findOrfail($id);
        $producto->delete();
        return response()->json(['message' => 'Eliminado con exito']);
    }
}

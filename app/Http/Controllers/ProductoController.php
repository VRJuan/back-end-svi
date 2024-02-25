<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // query con pagenate para consulta
        $productos = Producto::select('productos.*', 'categorias.nombre as categorias')
            ->join('categorias', 'productos.categoria_id', '=', 'categorias.id')
            ->paginate(10);

        return response()->json($productos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $reglas = [
            'nombre' => 'required|string|min:3|max:150',
            'descripcion' => 'nullable|max:1024',
            'categoria_id' => 'required|exists:categorias,id',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:0',
        ];
        $validador = Validator::make($request->input(), $reglas);
        if ($validador->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'errors' => $validador->errors()->all()
                ],
                400
            );
        }
        $producto = new Producto($request->input());
        $producto->save();
        return response()->json(
            [
                'status' => true,
                'message' => 'Producto creado con exito',
                'id' => $producto->fresh()->id
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        return response()->json(
            [
                'status' => true,
                'data' => $producto
            ],
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        $reglas = [
            'nombre' => 'required|string|min:3|max:150',
            'descripcion' => 'nullable|max:1024',
            'categoria_id' => 'required|exists:categorias,id',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:0',
        ];
        $validador = Validator::make($request->input(), $reglas);
        if ($validador->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'errors' => $validador->errors()->all()
                ],
                400
            );
        }
        $nombreProductoSinActulizar = $producto->nombre;
        $producto->update($request->input());
        return response()->json(
            [
                'status' => true,
                'message' => 'Producto actulizado con exito de:' . $nombreProductoSinActulizar . ' a ' . $producto->fresh()->nombre
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        $nombreProductoAEliminar = $producto->nombre;
        $producto->delete();

        return response()->json(
            [
                'status' => true,
                'message' => 'Se ha eliminado el producto: ' . $nombreProductoAEliminar
            ],
            200
        );
    }

    public function todosLosProductos()
    {
        $productos = Producto::select('productos.*', 'categorias.nombre as categorias')
            ->join('categorias', 'productos.categoria_id', '=', 'categorias.id')
            ->get();

        return response()->json($productos);
    }
}

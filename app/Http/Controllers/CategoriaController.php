<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::all();
        return response()->json($categorias);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $reglas = [
            'nombre' => 'required|min:3|max:150',
            'descripcion' => 'nullable|max:1024',
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

        $categoria = new Categoria($request->input());
        $categoria->save();

        return response()->json(
            [
                'status' => true,
                'message' => 'Se ha creado la categoria: ' . $categoria->fresh()->nombre . ' Correctamente',
                'id' => $categoria->fresh()->id
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        return response()->json(['status' => true, 'data' => $categoria]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $reglas = [
            'nombre' => 'required|min:3|max:150',
            'descripcion' => 'nullable|max:1024',
        ];

        $validador = Validator::make($request->input(), $reglas);
        if ($validador->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'errors' => $validador->errors()->all()
                ],
                200
            );
        }
        $categoriaSinActualizar = $categoria->fresh()->nombre;
        $categoria->update($request->input());
        return response()->json(
            [
                'status' => true,
                'message' => 'Se actulizo correctamente la categoria',
                'log' => 'Se actulizado la categoria:' . $categoriaSinActualizar . ' a ' .
                    $categoria->fresh()->nombre
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        $nombreCategoriaElimina = $categoria->nombre;
        $categoria->delete();

        return response()->json(
            [
                'status' => true,
                'message' => 'Se ha eliminado la categoria: ' . $nombreCategoriaElimina
            ],
            200
        );
    }
}

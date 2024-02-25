<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cargos = Cargo::all();
        return response()->json($cargos);
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
        $cargo = new Cargo($request->input());
        $cargo->save();
        return response()->json(
            [
                'status' => true,
                'message' => 'Se ha creado el cargo correctamente'
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Cargo $cargo)
    {
        return response()->json(['status' => true, 'data' => $cargo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cargo $cargo)
    {
        $reglas = [
            'nombre' => 'required|min:10|max:150',
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
        $cargo->update($request->input());
        return response()->json(
            [
                'status' => true,
                'message' => 'Se ha actulizado el cargo correctamente'
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cargo $cargo)
    {
        if (!$cargo->exists) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'El cargo no existe'
                ],
                404
            );
        }

        // El cargo existe, proceder a eliminarlo
        $cargo->delete();

        return response()->json(
            [
                'status' => true,
                'message' => 'Se ha eliminado el cargo correctamente'
            ],
            200
        );
    }
}

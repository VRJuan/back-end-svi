<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Cargo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // query con pagenate para consulta
        $usuarios = Usuario::select('usuarios.*', 'cargos.nombre as cargo')
            ->join('cargos', 'usuarios.cargo_id', '=', 'cargos.id')
            ->paginate(10);

        return response()->json($usuarios);
    }
    public function store(Request $request)
    {
        $reglas = [
            'nombre' => 'required|string|min:10|max:150',
            'correo' => 'required|email|min:10|max:150',
            'cedula' => 'required|string|min:6|max:30',
            'fecha_nacimiento' => 'required|date',
            'cargo_id' => 'required|exists:cargos,id',
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
        $usuario = new Usuario($request->input());
        $usuario->save();
        return response()->json(
            [
                'status' => true,
                'errors' => 'Empleado creado con exito'
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Usuario $usuario)
    {
        return response()->json(
            [
                'status' => true,
                'data' => $usuario
            ],
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Usuario $usuario)
    {
        $reglas = [
            'nombre' => 'required|string|min:10|max:150',
            'correo' => 'required|email|min:10|max:150',
            'cedula' => 'required|string|min:6|max:30',
            'fecha_nacimiento' => 'required|date',
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
        $usuario->update($request->input());
        return response()->json(
            [
                'status' => true,
                'errors' => 'Empleado actualizado con exito'
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return response()->json(
            [
                'status' => true,
                'errors' => 'Empleado eliminado con exito'
            ],
            200
        );
    }

    public function UsuariosPorCargo()
    {
        $usuariosPorCargo = Usuario::select('cargos.id', 'cargos.nombre', DB::raw('COUNT(usuarios.id) as count'))
            ->rightJoin('cargos', 'cargos.id', '=', 'usuarios.cargo_id')
            ->groupBy('cargos.id', 'cargos.nombre')
            ->get();

        return response()->json($usuariosPorCargo);
    }

    public function TodosLosUsuarios()
    {
        $usuarios = Usuario::select('usuarios.*', 'cargos.nombre as cargo')
            ->join('cargos', 'usuarios.cargo_id', '=', 'cargos.id')
            ->get();

        return response()->json($usuarios);
    }
}

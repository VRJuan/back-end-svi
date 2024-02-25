<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    use HasApiTokens;

    public function crearUsuario(Request $request)
    {
        $rules = [
            'name' => 'required|string|min:10|max:150',
            'email' => 'required|email|min:10|max:150|unique:users',
            'password' => 'required|string|min:8|max:150'
        ];

        $validator = Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'errors' => $validator->errors()->all()
                ],
                400
            );
        }

        $authUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json(
            [
                'status' => true,
                'message' => 'User created successfully',
                'token' => $authUser->createToken('API-TOKEN')->plainTextToken
            ],
            200
        );
    }

    public function loginUsuario(Request $request)
    {
        $rules = [
            'email' => 'required|email|min:10|max:150',
            'password' => 'required|string'
        ];

        $validator = Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'errors' => $validator->errors()->all()
                ],
                400
            );
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(
                [
                    'status' => false,
                    'error' => ['Unauthorized']
                ],
                401
            );
        }

        $authUser = User::where('email', $request->email)->first();

        return response()->json(
            [
                'status' => true,
                'message' => 'User logged in successfully',
                'data' => $authUser,
                'token' => $authUser->createToken('API-TOKEN')->plainTextToken
            ],
            200
        );
    }

    public function cerrarSesionUsuario()
    {
        auth()->user()->tokens()->delete();

        return response()->json(
            [
                'status' => true,
                'message' => 'Session closed successfully'
            ],
            200
        );
    }
}

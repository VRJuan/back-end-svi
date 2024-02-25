<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/cargos/*')) {
                $id = $request->route('cargo');
                return response()->json([
                    "status" => false,
                    "message" => "No existe el cargo con id: $id"
                ], 404);
            }
        });
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/usuarios/*')) {
                $id = $request->route('usuario');
                return response()->json([
                    "status" => false,
                    "message" => "No existe el empleado con id: $id"
                ], 404);
            }
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/categorias/*')) {
                $id = $request->route('categoria');
                return response()->json([
                    "status" => false,
                    "message" => "No la existe la categoria con el id: $id"
                ], 404);
            }
        });
    }
}

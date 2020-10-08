<?php

/** Gestiona las excepciones generadas por el sistema */
namespace App\Exceptions;

//use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use PhpOffice\PhpSpreadsheet\Reader\Exception as PhpOfficeException;
use App\Roles\Exceptions\PermissionDeniedException;
use App\Roles\Exceptions\LevelDeniedException;
use App\Roles\Exceptions\RoleDeniedException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Listado de tipos de exepciones que no son reportadas.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * Listado de campos que no son capturados para la validación de exepciones
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Reporta o registra una exepción
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Genera una exepción dentro de una respuesta HTTP.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof TokenMismatchException) {
            /** Captura una exepción por inactividad */
            session()->flash('message', ['type' => 'deny', 'msg' => 'Sessión expirada por inactividad.']);
            return redirect()->route('index');
        }

        if ($exception instanceof MethodNotAllowedHttpException && $request->path() === "logout") {
            /** Captura una exepción cuando el método usado no esta permitido */
            session()->flash('message', ['type' => 'deny', 'msg' => 'Usted ha salido del sistema']);
            return redirect()->route('index');
        }

        if (
            $exception instanceof PermissionDeniedException ||
            $exception instanceof LevelDeniedException ||
            $exception instanceof RoleDeniedException
        ) {
            if ($exception instanceof PermissionDeniedException) {
                /** @var string Mensaje de restricción de acceso para cuando no dispone de los permisos requeridos */
                $msg = 'No dispone de permisos para acceder a esta funcionalidad';
            } elseif ($exception instanceof LevelDeniedException) {
                /** @var string Mensaje de restricción de acceso para cuando no dispone del nivel de acceso requerido */
                $msg = 'Su nivel de acceso no le permite acceder a esta funcionalidad';
            } elseif ($exception instanceof RoleDeniedException) {
                /** @var string Mensaje de restricción de acceso para cuando no dispone del rol requerido */
                $msg = 'El rol asignado no le permite acceder a esta funcionalidad';
            }

            if ($request->ajax()) {
                return response()->json(['result' => false, 'message' => $msg], 403);
            }

            $request->session()->flash('message', ['type' => 'deny', 'msg' => $msg]);

            if (url()->current() === url()->previous()) {
                return redirect()->route('index');
            }

            return redirect()->back();
        }

        if ($exception instanceof PhpOfficeException) {
            /** Excepción capturada cuando un archivo a importar es inválido */
            $msg = 'El archivo a importar es inválido. Revise que los datos de la cabecera sean ' .
                   'correctos y que contenga información.';

            if ($request->ajax()) {
                return response()->json(['result' => false, 'message' => $msg], 200);
            }

            $request->session()->flash('message', [
                'type' => 'other', 'msg' => $msg, 'title' => 'Error!', 'icon' => 'screen-error',
                'class' => 'growl-danger'
            ]);
        }

        return parent::render($request, $exception);
    }
}

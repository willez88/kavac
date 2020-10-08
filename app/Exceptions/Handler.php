<?php

/** Gestiona las excepciones generadas por el sistema */
namespace App\Exceptions;

//use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof TokenMismatchException) {
            /** Exception catch by inactivity */
            session()->flash('message', ['type' => 'deny', 'msg' => 'Sessión expirada por inactividad.']);
            return redirect()->route('index');
        }

        if ($exception instanceof MethodNotAllowedHttpException && $request->path() === "logout") {
            /** Exception catch when method is not permited */
            session()->flash('message', ['type' => 'deny', 'msg' => 'Usted ha salido del sistema']);
            return redirect()->route('index');
        }

        if ($exception instanceof \App\Roles\Exceptions\PermissionDeniedException) {
            /** Exception catch when deny access by permissions */
            $msg = 'No dispone de permisos para acceder a esta funcionalidad';

            if ($request->ajax()) {
                return response()->json(['result' => false, 'message' => $msg], 403);
            }

            $request->session()->flash('message', ['type' => 'deny', 'msg' => $msg]);

            if (url()->current() === url()->previous()) {
                return redirect()->route('index');
            }

            return redirect()->back();
        }

        if ($exception instanceof \App\Roles\Exceptions\LevelDeniedException) {
            /** Exception catch when deny access by levels */
            $msg = 'Su nivel de acceso no le permite acceder a esta funcionalidad';

            if ($request->ajax()) {
                return response()->json(['result' => false, 'message' => $msg], 403);
            }

            $request->session()->flash('message', ['type' => 'deny', 'msg' => $msg]);

            if (url()->current() === url()->previous()) {
                return redirect()->route('index');
            }

            return redirect()->back();
        }

        if ($exception instanceof \App\Roles\Exceptions\RoleDeniedException) {
            /** Exception catch when deny access by roles */
            $msg = 'El rol asignado no le permite acceder a esta funcionalidad';

            if ($request->ajax()) {
                return response()->json(['result' => false, 'message' => $msg], 403);
            }

            $request->session()->flash('message', ['type' => 'deny', 'msg' => $msg]);

            if (url()->current() === url()->previous()) {
                return redirect()->route('index');
            }

            return redirect()->back();
        }

        if ($exception instanceof \PhpOffice\PhpSpreadsheet\Reader\Exception) {
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ModelsTrait;

class DashboardController extends Controller
{
    use ModelsTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->check()) {
            $trashed = [];
            foreach ($this->getModels() as $model_name) {
                $model = app($model_name);
                if (count($model->onlyTrashed()->get()) > 0) {
                    $trashed[$model_name] = $model->onlyTrashed()->get();
                }
            }

            /** Si el usuario esta autenticado redirecciona a la página del panel de control */
            return view('dashboard.index');
        }
        else {
            /** Si el usuario no está autenticado muestra la página de acceso */
            return view('auth.login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

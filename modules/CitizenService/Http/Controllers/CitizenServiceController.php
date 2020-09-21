<?php

namespace Modules\CitizenService\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

class CitizenServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('citizenservice::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('citizenservice::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Renderable
     */
    public function show()
    {
        return view('citizenservice::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Renderable
     */
    public function edit()
    {
        return view('citizenservice::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Renderable
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Renderable
     */
    public function destroy()
    {
    }
}

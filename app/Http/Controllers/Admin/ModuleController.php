<?php

/** Controladores de uso exclusivo para usuarios administradores */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Module;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::all();

        return view('admin.setting-modules', compact('modules'));
    }

    public function enable(Request $request)
    {
        $module = Module::findOrFail($request->module);
        $module->enable();

        return response()->json(['result' => true], 200);
    }

    public function disable(Request $request)
    {
        $module = Module::findOrFail($request->module);
        $module->disable();

        return response()->json(['result' => true], 200);
    }
}

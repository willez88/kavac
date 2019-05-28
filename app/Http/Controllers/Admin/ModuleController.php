<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Module;

class ModuleController extends Controller
{
    public function index()
    {
    	$modules = Module::all();

    	return view('admin.setting-modules', compact('modules'));
    }
}

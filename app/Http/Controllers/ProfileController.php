<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        Profile::updateOrCreate(
            ['user_id' => $request->user_id],
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name ?? null,
                'image_id' => $request->image_id ?? null,
            ]
        );
        return response()->json(['result' => true], 200);
    }
}

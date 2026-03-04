<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DjangoController extends Controller
{
    public function traer_recetas()
    {
        $response = Http::get('http://localhost:8000/api/recipes/')
            ->json();
        return response()->json($response);
    }

    public function guardar_receta(Request $request)
    {
        $response = Http::post('http://localhost:8000/api/recipes/', [
            'name' => $request->name,
            'description' => $request->description,
            'ingredients' => $request->ingredients,
        ])->json();

        return response()->json($response);
    }
}

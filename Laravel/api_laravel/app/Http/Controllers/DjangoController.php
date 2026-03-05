<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DjangoController extends Controller
{
    public function traer_productos()
    {
        $baseUrl = config('services.django.base_url'); // DJANGO_BASE_URL: http://127.0.0.1:8001 

        $response = Http::baseUrl($baseUrl)
            ->get('/api/productos/')
            ->json();

        return response()->json($response);
    }


    public function guardar_producto(Request $request)
    {
        $baseUrl = config('services.django.base_url');

        $payload = [
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
        ];

        $response = Http::baseUrl($baseUrl)
            ->post('/api/productos/', $payload)
            ->json();

        return response()->json($response);
    }
}

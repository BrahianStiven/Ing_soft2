<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DjangoController extends Controller
{
    public function traer_productos()
    {
        $baseUrl = config('services.django.base_url');

        $token = 'miclave123';

        $response = Http::baseUrl($baseUrl)
            ->withHeaders(['Authorization' => "Token $token"])
            ->get('/api/productos/')
            ->json();

        return response()->json($response);
    }

    public function guardar_producto(Request $request)
    {
        $baseUrl = config('services.django.base_url');

        $token = 'miclave123';

        $payload = [
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
        ];

        $response = Http::baseUrl($baseUrl)
            ->withHeaders(['Authorization' => "Token $token"])
            ->post('/api/productos/', $payload)
            ->json();

        return response()->json($response);
    }
}

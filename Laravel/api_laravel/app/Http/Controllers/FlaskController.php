<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FlaskController extends Controller
{
    public function traer_users()
    {
        $baseUrl = 'http://127.0.0.1:8002';
        $token = 'miclave123';

        $res = Http::baseUrl($baseUrl)
            ->withHeaders(['Authorization' => "Token $token"])
            ->get('/api/users');

        return response()->json($res->json(), $res->status());
    }

    public function guardar_user(Request $request)
    {
        $baseUrl = 'http://127.0.0.1:8002';
        $token = 'miclave123';

        $payload = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        $res = Http::baseUrl($baseUrl)
            ->withHeaders(['Authorization' => "Token $token"])
            ->post('api/users', $payload);

        return response()->json($res->json(), $res->status());
    }
}

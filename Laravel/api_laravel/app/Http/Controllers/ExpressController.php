<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ExpressController extends Controller
{
    private string $baseUrl = 'http://127.0.0.1:3000';
    private string $token = 'miclave123';

    private function client()
    {
        return Http::baseUrl($this->baseUrl)
            ->withHeaders(['Authorization' => "Token {$this->token}"]);
    }

    public function index()
    {
        $res = $this->client()->get('/users');
        return response()->json($res->json(), $res->status());
    }

    public function store(Request $request)
    {
        $payload = $request->only(['name', 'email']);
        $res = $this->client()->post('/users', $payload);
        return response()->json($res->json(), $res->status());
    }

    public function show($id)
    {
        $res = $this->client()->get("/users/{$id}");
        return response()->json($res->json(), $res->status());
    }

    public function update(Request $request, $id)
    {
        $payload = $request->only(['name', 'email']);
        $res = $this->client()->put("/users/{$id}", $payload);
        return response()->json($res->json(), $res->status());
    }

    public function destroy($id)
    {
        $res = $this->client()->delete("/users/{$id}");
        return response()->json($res->json(), $res->status());
    }
}

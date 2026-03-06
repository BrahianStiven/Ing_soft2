<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IngredientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DjangoController;
use App\Http\Controllers\ExpressController;
use App\Http\Controllers\FlaskController;

use Illuminate\Support\Facades\Http;


/********** Rutas para el controlador de usuarios **********/
Route::get("/users", [UserController::class, "index"]);
Route::post("/users", [UserController::class, "store"]);
Route::put("/users/{id}", [UserController::class, "update"]);
Route::delete("/users/{id}", [UserController::class, "destroy"]);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/me', function (Request $request) {
    return response()->json($request->user(), 200);
})->middleware('auth:sanctum');

Route::post('/recuperar', [UserController::class, 'recuperarPassword']);

/********** Rutas para el controlador de Django **********/
Route::get('/productos', [DjangoController::class, 'traer_productos']);
Route::post('/productos', [DjangoController::class, 'guardar_producto']);

/********** Rutas para el controlador de Flask ***********/
Route::get('/flask/users', [FlaskController::class, 'traer_users']);
Route::post('flask/users', [FlaskController::class, 'guardar_user']);

/********** Rutas para el controlador de Express ***********/
Route::get('/express/users', [ExpressController::class, 'index']);
Route::post('/express/users', [ExpressController::class, 'store']);
Route::get('/express/users/{id}', [ExpressController::class, 'show']);
Route::put('/express/users/{id}', [ExpressController::class, 'update']);
Route::delete('/express/users/{id}', [ExpressController::class, 'destroy']);

Route::get("/ingredients", [IngredientController::class, "index"]);
Route::post("/ingredients", [IngredientController::class, "store"]);
Route::put("/ingredients/{id}", [IngredientController::class, "update"]);
Route::delete("/ingredients/{id}", [IngredientController::class, "destroy"]);


Route::get('/prueba', function () {
    return redirect('https://fakestoreapi.com/products');
});

Route::get('/prueba2', function () {
    return ('https://fakestoreapi.com/products');
});

Route::get('/prueba3', function () {
    return
        $response = Http::get('https://fakestoreapi.com/products')
        ->json();
});

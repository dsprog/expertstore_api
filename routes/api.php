<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductCategoryController;
use App\Http\Controllers\API\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
Route::apiResource('products', ProductController::class)
    ->only(["index", "show"]);
Route::apiResource('products.categories', ProductCategoryController::class)->only("index");


// lavada09@example.net | password
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('products', ProductController::class)
    ->only(['store', 'update', 'destroy'])
    ->middleware('auth:sanctum');


/*
Route::controller(\App\Http\Controllers\API\ProductController::class)
    ->prefix('products')
    ->group(function(){
        Route::get('/', 'index');
        Route::get('/{product}', 'show');
        Route::post('/','store');
        Route::match(['put', 'patch'], '/{product}', 'update');
        Route::delete('/{product}', 'destroy');
    }
);
*/

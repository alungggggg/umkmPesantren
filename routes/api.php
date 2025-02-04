<?php

use App\Http\Controllers\menuController;
use App\Http\Controllers\umkmController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// umkm
// id, image, namaUmkm, deskripsiSingkat, kategori, whatsApp, maps, facebook, instagram, tiktok
Route::get('/umkm/menu/{id}', [umkmController::class, "menuUmkm"]);
Route::post("/umkm", [umkmController::class, "create"]);
Route::get("/umkm", [umkmController::class, "get"]);
Route::delete("/umkm", [umkmController::class, "delete"]);
Route::get("/umkm/{id}", [umkmController::class, "getById"]);
Route::post("/umkm/{id}", [umkmController::class, "update"]);
Route::get("/umkm/category/minuman", [umkmController::class, "getAllMinuman"]);
Route::get("/umkm/category/jasa", [umkmController::class, "getAllJasa"]);
Route::get("/umkm/category/makanan", [umkmController::class, "getAllMakanan"]);


// daftarMenu foreign key umkm
// id, namaMakanan, image
Route::get('/menu', [menuController::class, "get"]);
Route::post('/menu', [menuController::class, "create"]);
Route::delete('/menu', [menuController::class, "delete"]);
Route::get('/menu/{id}', [menuController::class, "getById"]);
Route::post('/menu/{id}', [menuController::class, "update"]);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PregnantMotherController;

Route::get('/ibu-hamil', [PregnantMotherController::class, 'index']);
Route::post('/ibu-hamil', [PregnantMotherController::class, 'store']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

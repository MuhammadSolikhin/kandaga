<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PregnantMotherController;
use App\Http\Controllers\Api\ChildHealthRecordController;

Route::get('/ibu-hamil', [PregnantMotherController::class, 'index']);
Route::post('/ibu-hamil', [PregnantMotherController::class, 'store']);

Route::get('/balita', [ChildHealthRecordController::class, 'index']);
Route::post('/balita', [ChildHealthRecordController::class, 'store']);
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

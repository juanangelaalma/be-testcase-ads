<?php

use App\Http\Controllers\KaryawanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::prefix('karyawan')->group(function() {
    Route::get('/', [KaryawanController::class, 'getAllKaryawan']);
    Route::post('/', [KaryawanController::class, 'createKaryawan']);
    Route::put('/', [KaryawanController::class, 'updateKaryawan']);
    Route::put('/', [KaryawanController::class, 'deleteKaryawan']);
});

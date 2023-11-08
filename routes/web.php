<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Origin: *');

Route::get('/test/{record}', function () {
    return "hola";
})->name('test');

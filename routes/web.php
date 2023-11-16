<?php

use App\Http\Controllers\UserSalaryController;
use App\Models\User;
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

Route::get('/entity/get', [App\Http\Controllers\EntityController::class, 'getEntities'])->name('entity.get');
Route::post('/entity/segment/store', [App\Http\Controllers\EntityController::class, 'storeSegment'])->name('entity.segment.store');
Route::post('/entity/shift/store', [App\Http\Controllers\EntityController::class, 'storeShift'])->name('entity.shift.store');
Route::post('/entity/shift/edit/{shift}', [App\Http\Controllers\EntityController::class, 'editShift'])->name('entity.shift.edit');
Route::get('/entity/getEmployee/{segment}', [App\Http\Controllers\EntityController::class, 'getEmployees'])->name('entity.get');
Route::get('/entity/getShift/{shift}', [App\Http\Controllers\EntityController::class, 'getShift'])->name('entity.get.shift');
Route::get('/entity/shift/delete/{shift}', [App\Http\Controllers\EntityController::class, 'deleteShift'])->name('entity.delete.shift');


Route::get('/getUsersSalary/{segment}', [UserSalaryController::class, 'getUsersSalary']);

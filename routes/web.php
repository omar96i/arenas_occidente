<?php

use App\Http\Controllers\UserSalaryController;
use App\Models\EquipmentMachinery;
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

Route::get('/test/scraping', [App\Http\Controllers\ScrapingController::class, 'index']);
Route::get('/user/get', [App\Http\Controllers\UserController::class, 'get'])->name('user.get');


Route::get('/entity/get', [App\Http\Controllers\EntityController::class, 'getEntities'])->name('entity.get');
Route::post('/entity/segment/store', [App\Http\Controllers\EntityController::class, 'storeSegment'])->name('entity.segment.store');
Route::post('/entity/shift/store', [App\Http\Controllers\EntityController::class, 'storeShift'])->name('entity.shift.store');
Route::post('/entity/shift/edit/{shift}', [App\Http\Controllers\EntityController::class, 'editShift'])->name('entity.shift.edit');
Route::post('/entity/update/date/shift/{shift}', [App\Http\Controllers\EntityController::class, 'editShiftDate'])->name('entity.shift.edit.date');
Route::get('/entity/getEmployee/{segment}', [App\Http\Controllers\EntityController::class, 'getEmployees'])->name('entity.get');
Route::get('/entity/getShift/{shift}', [App\Http\Controllers\EntityController::class, 'getShift'])->name('entity.get.shift');
Route::get('/entity/shift/delete/{shift}', [App\Http\Controllers\EntityController::class, 'deleteShift'])->name('entity.delete.shift');

Route::get('/equipmentMachinary/get', [App\Http\Controllers\EquipmentMachinaryController::class, 'get'])->name('equipment.machinary.get');

Route::get('/equipmentMachinary/fuels/get/{month}/{year}', [App\Http\Controllers\EquipmentMachinaryController::class, 'getFuels'])->name('equipment.machinary.get.fuels');

Route::get('/getUsersSalary/{segment}', [UserSalaryController::class, 'getUsersSalary']);
Route::post('/maintenance/scheduling/store', [App\Http\Controllers\MaintenanceSchedulingController::class, 'store'])->name('maintenance.scheduling.store');
Route::post('/maintenance/scheduling/update/{scheduling}', [App\Http\Controllers\MaintenanceSchedulingController::class, 'update'])->name('maintenance.scheduling.update');
Route::get('/maintenance/scheduling/get/{scheduling}', [App\Http\Controllers\MaintenanceSchedulingController::class, 'get'])->name('maintenance.scheduling.get');
Route::get('/maintenance/scheduling/delete/{scheduling}', [App\Http\Controllers\MaintenanceSchedulingController::class, 'delete'])->name('maintenance.scheduling.delete');
Route::get('/maintenance/scheduling/actual', [App\Http\Controllers\MaintenanceSchedulingController::class, 'getToday'])->name('maintenance.scheduling.get.today');




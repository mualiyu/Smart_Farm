<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mainController;
use App\Http\Controllers\actuatorController;
use App\Http\Controllers\sensorController;
use App\Http\Controllers\mqttController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [mainController::class, "index"])->name("home");

Route::get('/actuators', [actuatorController::class, "index"])->name("actuators");
Route::get('/actuator/{id}', [actuatorController::class, "show_single"])->name("show_single_actuator");
Route::get('/actuators/create', [actuatorController::class, "show_create"])->name('show_create_actuator')->middleware('is_admin');
Route::post('/actuator', [actuatorController::class, "create"])->name('store_actuator')->middleware('is_admin');


Route::get('/sensors', [sensorController::class, "index"])->name("sensors");
Route::get('/sensor/{id}', [sensorController::class, "show_single"])->name("show_single_sensor");
Route::get('/sensors/create', [sensorController::class, "show_create"])->name("show_create_sensor")->middleware('is_admin');
Route::post('/sensor', [sensorController::class, "create"])->name('store_sensor')->middleware('is_admin');

Route::post('/channgepump', [mqttController::class, "pub"])->name('publishStatus');
Route::post('/channgemode', [mqttController::class, "pubMode"])->name('publishStatusMode');

Auth::routes(['verify' => true]);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);

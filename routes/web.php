<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/pacienteIndex', [App\Http\Controllers\PacienteController::class, 'index'])->name('pacienteIndex');
Route::get('/pacienteCreate', [App\Http\Controllers\PacienteController::class, 'create'])->name('pacienteCreate');
Route::post('/savePaciente', [App\Http\Controllers\PacienteController::class, 'savePaciente']);
Route::get('/update_paciente/{id}', [App\Http\Controllers\PacienteController::class, 'update_view']);
Route::post('/updatePaciente/{id}', [App\Http\Controllers\PacienteController::class, 'update']);
Route::get('/visualizar_paciente/{id}', [App\Http\Controllers\PacienteController::class, 'show']);
Route::post('/visualizarPaciente/{id}', [App\Http\Controllers\PacienteController::class, 'visualizar']);
Route::delete('/paciente/{id}', 'App\Http\Controllers\PacienteController@delete')->name('pacientes.delete');


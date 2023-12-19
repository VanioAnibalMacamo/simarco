<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;

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


Route::get('/pacienteIndex', [PacienteController::class, 'index'])->name('pacienteIndex');
Route::get('/pacienteCreate', [PacienteController::class, 'create'])->name('pacienteCreate');
Route::post('/savePaciente', [PacienteController::class, 'savePaciente']);
Route::get('/update_paciente/{id}', [PacienteController::class, 'edit'])->name('pacientes.edit');
Route::post('/update_paciente/{id}', [PacienteController::class, 'update'])->name('pacientes.update');
Route::get('/visualizar_paciente/{id}', [PacienteController::class, 'show']);
Route::post('/visualizarPaciente/{id}', [PacienteController::class, 'visualizar']);
Route::delete('/paciente/{id}', 'PacienteController@delete')->name('pacientes.delete');


<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\EspecialidadeController;
use App\Http\Controllers\MedicoController;

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
Route::delete('/paciente/{id}', 'App\Http\Controllers\PacienteController@delete')->name('pacientes.delete');

Route::get('/especialidadeIndex', [EspecialidadeController::class, 'index'])->name('especialidadeIndex');
Route::get('/especialidadeCreate', [EspecialidadeController::class, 'create'])->name('especialidadeCreate');
Route::post('/saveEspecialidade', [EspecialidadeController::class, 'store'])->name('saveEspecialidade');
Route::get('/update_especialidade/{id}', [EspecialidadeController::class, 'edit'])->name('especialidades.edit');
Route::post('/update_especialidade/{id}', [EspecialidadeController::class, 'update'])->name('especialidades.update');
Route::get('/visualizar_especialidade/{id}', [EspecialidadeController::class, 'show']);
Route::delete('/especialidade/{id}', [EspecialidadeController::class, 'destroy'])->name('especialidades.delete');

Route::get('/medicoIndex', [MedicoController::class, 'index'])->name('medicoIndex');
Route::get('/medicoCreate', [MedicoController::class, 'create'])->name('medicoCreate');
Route::post('/saveMedico', [MedicoController::class, 'saveMedico']);
Route::get('/update_medico/{id}', [MedicoController::class, 'edit'])->name('medicos.edit');
Route::post('/update_medico/{id}', [MedicoController::class, 'update'])->name('medicos.update');
Route::get('/visualizar_medico/{id}', [MedicoController::class, 'show']);
Route::post('/visualizarMedico/{id}', [MedicoController::class, 'visualizar']);
Route::delete('/medico/{id}', [MedicoController::class, 'destroy'])->name('medicos.delete');

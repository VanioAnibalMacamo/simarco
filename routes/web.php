<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\EspecialidadeController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\ViaAdministracaoController;
<<<<<<< Updated upstream
use App\Http\Controllers\FormaFarmaceuticaController;
=======
use App\Http\Controllers\FabricanteController;
>>>>>>> Stashed changes

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
Route::put('/update_medico/{id}', [MedicoController::class, 'update'])->name('medicos.update');
Route::get('/visualizar_medico/{id}', [MedicoController::class, 'show']);
Route::post('/visualizarMedico/{id}', [MedicoController::class, 'visualizar']);
Route::delete('/medico/{id}', [MedicoController::class, 'delete'])->name('medicos.delete');

Route::get('/consultaIndex', [ConsultaController::class, 'index'])->name('consultaIndex');
Route::get('/consultaCreate', [ConsultaController::class, 'create'])->name('consultaCreate');
Route::post('/saveConsulta', [ConsultaController::class, 'saveConsulta']);
Route::get('/update_consulta/{id}', [ConsultaController::class, 'edit'])->name('consultas.edit');
Route::post('/update_consulta/{id}', [ConsultaController::class, 'update'])->name('consultas.update');
Route::get('/visualizar_consulta/{id}', [ConsultaController::class, 'show']);
Route::delete('/consulta/{id}', [ConsultaController::class, 'delete'])->name('consultas.delete');

Route::get('/statusIndex', [StatusController::class, 'index'])->name('statusIndex');
Route::get('/statusCreate', [StatusController::class, 'create'])->name('statusCreate');
Route::post('/saveStatus', [StatusController::class, 'store'])->name('saveStatus');
Route::get('/update_status/{id}', [StatusController::class, 'edit'])->name('status.edit');
Route::post('/update_status/{id}', [StatusController::class, 'update'])->name('status.update');
Route::get('/visualizar_status/{id}', [StatusController::class, 'show']);
Route::delete('/status/{id}', [StatusController::class, 'destroy'])->name('status.delete');

Route::get('/via_administracaoIndex', [ViaAdministracaoController::class, 'index'])->name('via_administracaoIndex');
Route::get('/via_administracao/create', [ViaAdministracaoController::class, 'create'])->name('via_administracao.create');
Route::post('/via_administracao/store', [ViaAdministracaoController::class, 'store'])->name('via_administracao.store');
Route::get('/via_administracao/edit/{id}', [ViaAdministracaoController::class, 'edit'])->name('via_administracao.edit');
Route::post('/via_administracao/update/{id}', [ViaAdministracaoController::class, 'update'])->name('via_administracao.update');
Route::get('/via_administracao/show/{id}', [ViaAdministracaoController::class, 'show'])->name('via_administracao.show');
Route::delete('/via_administracao/{id}', [ViaAdministracaoController::class, 'destroy'])->name('via_administracao.delete');

<<<<<<< Updated upstream
Route::get('/forma_farmaceutica', [FormaFarmaceuticaController::class, 'index'])->name('forma_farmaceutica.index');
Route::get('/forma_farmaceutica/create', [FormaFarmaceuticaController::class, 'create'])->name('forma_farmaceutica.create');
Route::post('/forma_farmaceutica/store', [FormaFarmaceuticaController::class, 'store'])->name('forma_farmaceutica.store');
Route::get('/forma_farmaceutica/edit/{id}', [FormaFarmaceuticaController::class, 'edit'])->name('forma_farmaceutica.edit');
Route::post('/forma_farmaceutica/update/{id}', [FormaFarmaceuticaController::class, 'update'])->name('forma_farmaceutica.update');
Route::delete('/forma_farmaceutica/{id}', [FormaFarmaceuticaController::class, 'destroy'])->name('forma_farmaceutica.delete');
=======
Route::get('/fabricanteIndex', [FabricanteController::class, 'index'])->name('fabricanteIndex');
Route::get('/fabricanteCreate', [FabricanteController::class, 'create'])->name('fabricanteCreate');
Route::post('/saveFabricante', [FabricanteController::class, 'saveFabricante']);
Route::get('/update_fabricante/{id}', [FabricanteController::class, 'edit'])->name('fabricantes.edit');
Route::put('/update_fabricante/{id}', [FabricanteController::class, 'update'])->name('fabricantes.update');
Route::get('/visualizar_fabricante/{id}', [FabricanteController::class, 'show']);
Route::post('/visualizarFabricante/{id}', [FabricanteController::class, 'visualizar']);
Route::delete('/fabricante/{id}', [FabricanteController::class, 'delete'])->name('fabricantes.delete');
>>>>>>> Stashed changes

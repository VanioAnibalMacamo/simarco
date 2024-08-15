<?php

use App\Http\Controllers\HorariosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\EspecialidadeController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\ViaAdministracaoController;
use App\Http\Controllers\FormaFarmaceuticaController;
use App\Http\Controllers\FabricanteController;
use App\Http\Controllers\MedicamentosController;
use App\Http\Controllers\DiagnosticosController;
use App\Http\Controllers\PrescricaoController;
use App\Http\Controllers\SintomaController;
use App\Http\Controllers\GravidadeController;
use App\Http\Controllers\PaginasController;
use App\Http\Controllers\DisponibilidadeController;
use App\Http\Controllers\AgendamentosController;
use App\Http\Controllers\VideoConferenciaController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;


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

Route::get('/home', [PaginasController::class, 'pacienteTipoConsulta'])->name('pacienteTipoConsulta');
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/pacienteIndex', [PacienteController::class, 'index'])->name('pacienteIndex');
Route::get('/pacienteCreate', [PacienteController::class, 'create'])->name('pacienteCreate');
Route::post('/savePaciente', [PacienteController::class, 'savePaciente']);
Route::get('/update_paciente/{id}', [PacienteController::class, 'edit'])->name('pacientes.edit');
Route::post('/update_paciente/{id}', [PacienteController::class, 'update'])->name('pacientes.update');
Route::get('/visualizar_paciente/{id}', [PacienteController::class, 'show']);
Route::post('/visualizarPaciente/{id}', [PacienteController::class, 'visualizar']);
Route::delete('/paciente/{id}', 'App\Http\Controllers\PacienteController@delete')->name('pacientes.delete');
Route::get('/paciente/download/{id}', [PacienteController::class, 'downloadCartaoSeguroSaude'])->name('paciente.downloadCartao');
Route::get('/paciente/{id}', [PacienteController::class, 'show'])->name('paciente.show');

Route::get('/especialidadeIndex', [EspecialidadeController::class, 'index'])->name('especialidadeIndex');
Route::get('/especialidadeCreate', [EspecialidadeController::class, 'create'])->name('especialidadeCreate');
Route::post('/saveEspecialidade', [EspecialidadeController::class, 'store'])->name('saveEspecialidade');
Route::get('/update_especialidade/{id}', [EspecialidadeController::class, 'edit'])->name('especialidades.edit');
Route::post('/update_especialidade/{id}', [EspecialidadeController::class, 'update'])->name('especialidades.update');
Route::get('/visualizar_especialidade/{id}', [EspecialidadeController::class, 'show']);
Route::delete('/especialidade/{id}', [EspecialidadeController::class, 'destroy'])->name('especialidades.delete');

Route::get('/medico/{id}', [MedicoController::class, 'show'])->name('medico.show');
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

Route::get('/forma_farmaceutica', [FormaFarmaceuticaController::class, 'index'])->name('forma_farmaceutica.index');
Route::get('/forma_farmaceutica/create', [FormaFarmaceuticaController::class, 'create'])->name('forma_farmaceutica.create');
Route::post('/forma_farmaceutica/store', [FormaFarmaceuticaController::class, 'store'])->name('forma_farmaceutica.store');
Route::get('/forma_farmaceutica/edit/{id}', [FormaFarmaceuticaController::class, 'edit'])->name('forma_farmaceutica.edit');
Route::post('/forma_farmaceutica/update/{id}', [FormaFarmaceuticaController::class, 'update'])->name('forma_farmaceutica.update');
Route::delete('/forma_farmaceutica/{id}', [FormaFarmaceuticaController::class, 'destroy'])->name('forma_farmaceutica.delete');

Route::get('/fabricanteIndex', [FabricanteController::class, 'index'])->name('fabricanteIndex');
Route::get('/fabricanteCreate', [FabricanteController::class, 'create'])->name('fabricanteCreate');
Route::post('/saveFabricante', [FabricanteController::class, 'saveFabricante']);
Route::get('/update_fabricante/{id}', [FabricanteController::class, 'edit'])->name('fabricantes.edit');
Route::put('/update_fabricante/{id}', [FabricanteController::class, 'update'])->name('fabricantes.update');
Route::get('/visualizar_fabricante/{id}', [FabricanteController::class, 'show']);
Route::post('/visualizarFabricante/{id}', [FabricanteController::class, 'visualizar']);
Route::delete('/fabricante/{id}', [FabricanteController::class, 'delete'])->name('fabricantes.delete');

Route::get('/medicamentoIndex', [MedicamentosController::class, 'index'])->name('medicamentoIndex');
Route::get('/medicamentoCreate', [MedicamentosController::class, 'create'])->name('medicamentoCreate');
Route::post('/saveMedicamento', [MedicamentosController::class, 'saveMedicamento']);
Route::get('/update_medicamento/{id}', [MedicamentosController::class, 'edit'])->name('medicamentos.edit');
Route::put('/update_medicamento/{id}', [MedicamentosController::class, 'update'])->name('medicamentos.update');
Route::get('/visualizar_medicamento/{id}', [MedicamentosController::class, 'show']);
Route::delete('/medicamento/{id}', [MedicamentosController::class, 'delete'])->name('medicamentos.delete');

Route::get('/diagnosticoIndex', [DiagnosticosController::class, 'index'])->name('diagnosticoIndex');
//Ao criar o diagnostico, mandamos o id da consulta que é para pegar o Paciente na consulta.
Route::get('/diagnosticoCreate/{consultaId}', [DiagnosticosController::class, 'create'])->name('diagnosticoCreate');
Route::post('/saveDiagnostico', [DiagnosticosController::class, 'saveDiagnostico']);
Route::get('/update_diagnostico/{id}', [DiagnosticosController::class, 'edit'])->name('diagnosticos.edit');
Route::put('/update_diagnostico/{id}', [DiagnosticosController::class, 'update'])->name('diagnosticos.update');
Route::get('/visualizar_diagnostico/{id}', [DiagnosticosController::class, 'show']);
Route::delete('/diagnostico/{id}', [DiagnosticosController::class, 'delete'])->name('diagnosticos.delete');
//Route::get('/diagnosticoCreateWithPaciente/{paciente}', [DiagnosticosController::class, 'createWithPaciente'])->name('diagnostico.createWithPaciente');

Route::get('/prescricaoIndex', [PrescricaoController::class, 'index'])->name('prescricaoIndex');
Route::get('/prescricaoCreate/{consultaId}', [PrescricaoController::class, 'create'])->name('prescricaoCreate');
Route::post('/savePrescricao', [PrescricaoController::class, 'savePrescricao']);
Route::get('/update_prescricao/{id}', [PrescricaoController::class, 'edit'])->name('prescricoes.edit');
Route::put('/update_prescricao/{id}', [PrescricaoController::class, 'update'])->name('prescricoes.update');
Route::get('/visualizar_prescricao/{id}', [PrescricaoController::class, 'show']);
Route::delete('/prescricao/{id}', [PrescricaoController::class, 'delete'])->name('prescricoes.delete');

Route::get('/sintomasIndex', [SintomaController::class, 'index'])->name('sintoma.index');
Route::get('/sintomaCreate', [SintomaController::class, 'create'])->name('sintoma.create');
Route::post('/sintoma/store', [SintomaController::class, 'store'])->name('sintoma.store');
Route::get('/sintoma/edit/{id}', [SintomaController::class, 'edit'])->name('sintoma.edit');
Route::put('/sintoma/update/{id}', [SintomaController::class, 'update'])->name('sintoma.update');
Route::get('/sintoma/view/{id}', [SintomaController::class, 'show'])->name('sintoma.show');
Route::delete('/sintoma/delete/{id}', [SintomaController::class, 'delete'])->name('sintoma.delete');

Route::get('/gravidadeIndex', [GravidadeController::class, 'index'])->name('gravidadeIndex');
Route::get('/gravidadeCreate', [GravidadeController::class, 'create'])->name('gravidadeCreate');
Route::post('/saveGravidade', [GravidadeController::class, 'store'])->name('saveGravidade');
Route::get('/update_gravidade/{id}', [GravidadeController::class, 'edit'])->name('gravidade.edit');
Route::put('/update_gravidade/{id}', [GravidadeController::class, 'update'])->name('gravidade.update');
Route::get('/visualizar_gravidade/{id}', [GravidadeController::class, 'show'])->name('gravidade.show');
Route::delete('/gravidade/{id}', [GravidadeController::class, 'destroy'])->name('gravidade.delete');

//Route::get('/pacienteTipoConsulta', [PaginasController::class, 'pacienteTipoConsulta'])->name('pacienteTipoConsulta');

Route::get('/marcar_consulta_especialidades', [MedicoController::class, 'marcar_consulta_especialidades'])->name('marcar_consulta_especialidades');
//Route::get('/medico/especialidades', [MedicoController::class, 'especialidades'])->name('medico.especialidades');
Route::get('/medico/medicos/{idEspecialidade}', [MedicoController::class, 'medicos'])->name('medico.medicos');

Route::get('/medicos/{id}/disponibilidade', [MedicoController::class, 'showDisponibilidade'])->name('medicos.disponibilidade');

Route::get('/disponibilidadeIndex', [DisponibilidadeController::class, 'index'])->name('disponibilidadeIndex');
Route::get('disponibilidadeCreate/{medico_id}', [DisponibilidadeController::class, 'create'])->name('disponibilidade.create');
Route::post('/disponibilidade/store', [DisponibilidadeController::class, 'store'])->name('disponibilidade.store');
Route::get('/disponibilidade/{id}/edit', [DisponibilidadeController::class, 'edit'])->name('disponibilidade.edit');
Route::put('/disponibilidade/{id}/update', [DisponibilidadeController::class, 'update'])->name('disponibilidade.update');
Route::delete('/disponibilidade/{id}/delete', [DisponibilidadeController::class, 'destroy'])->name('disponibilidade.delete');

Route::get('visualizar_disponibilidades/{id}',[DisponibilidadeController::class,'visualizarDisponibilidades'])->name('visualizar_disponibilidades');

Route::post('agendamentos', [AgendamentosController::class, 'store'])->name('agendamentos.store');
Route::get('/agendamentosMarcados', [AgendamentosController::class, 'agendamentosMarcados'])->name('agendamentosMarcados');

Route::get('/videoconferencia', [VideoConferenciaController::class, 'index']);
Route::get('/videoconferencia/{id}', [VideoConferenciaController::class, 'videoconferencia'])->name('videoconferencia');


Route::get('/horarios/{disponibilidade}', [HorariosController::class, 'index'])->name('horarios.index');

Route::get('/visualizar_agendamento/{id}', [AgendamentosController::class, 'show'])->name('agendamentos.show');

Route::get('empresas', [EmpresaController::class, 'index'])->name('empresas.index');
Route::get('empresas/create', [EmpresaController::class, 'create'])->name('empresas.create');
Route::post('empresas', [EmpresaController::class, 'store'])->name('empresas.store');
Route::get('empresas/{empresa}', [EmpresaController::class, 'show'])->name('empresas.show');
Route::get('empresas/{empresa}/edit', [EmpresaController::class, 'edit'])->name('empresas.edit');
Route::put('empresas/{empresa}', [EmpresaController::class, 'update'])->name('empresas.update');
Route::delete('empresas/{empresa}', [EmpresaController::class, 'destroy'])->name('empresas.destroy');

Route::get('send-email/{toEmail}/{message}/{subject}', [EmailController::class, 'sendEmail']);
Route::get('test-email', [EmailController::class, 'testEmail']);

Route::resource('users', UserController::class);
Route::resource('roles', RoleController::class);
Route::resource('permissions', PermissionController::class);

Route::get('/prescricao/{id}/download', [PrescricaoController::class, 'download'])->name('prescricao.download');
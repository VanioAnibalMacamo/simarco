<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmpresaCodigoFuncionarioCartaoSeguroSaudeToPacientesTable extends Migration
{
    public function up()
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->string('empresa')->nullable();
            $table->string('codigo_funcionario')->nullable();
            $table->string('cartao_seguro_saude')->nullable();
        });
    }

    public function down()
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->dropColumn(['empresa', 'codigo_funcionario', 'cartao_seguro_saude']);
        });
    }
}

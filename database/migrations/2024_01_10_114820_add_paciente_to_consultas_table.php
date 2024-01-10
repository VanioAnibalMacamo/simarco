<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPacienteToConsultasTable extends Migration
{
    public function up()
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->foreignId('paciente_id')->constrained('pacientes');
        });
    }

    public function down()
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->dropForeign(['paciente_id']);
            $table->dropColumn('paciente_id');
        });
    }
};

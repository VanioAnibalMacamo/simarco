<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultaPacienteTable extends Migration
{
    public function up()
    {
        Schema::create('consulta_paciente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->foreignId('paciente_id')->constrained('pacientes');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consulta_paciente');
    }
};

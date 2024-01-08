<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultaMedicoTable extends Migration
{
    public function up()
    {
        Schema::create('consulta_medico', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->foreignId('medico_id')->constrained('medicos');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consulta_medico');
    }
};

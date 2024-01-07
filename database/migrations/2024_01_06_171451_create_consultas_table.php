<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultasTable extends Migration
{
    public function up()
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->date('data_consulta');
            $table->string('duracao');
            $table->unsignedBigInteger('id_status');
            $table->text('observacoes')->nullable();
            $table->string('numero_identificacao');
            $table->timestamps();

            $table->foreign('id_status')->references('id')->on('status_consultas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('consultas');
    }
}

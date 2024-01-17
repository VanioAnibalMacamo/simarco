<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosticosTable extends Migration
{
    public function up()
    {
        Schema::create('diagnosticos', function (Blueprint $table) {
            $table->id();
            $table->date('data_diagnostico');
            $table->text('descricao');
            $table->text('observacoes')->nullable();
            $table->unsignedBigInteger('consulta_id');
            $table->timestamps();

            $table->foreign('consulta_id')->references('id')->on('consultas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('diagnosticos');
    }
};

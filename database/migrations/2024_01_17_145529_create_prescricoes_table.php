<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescricoesTable extends Migration
{
    public function up()
    {
        Schema::create('prescricoes', function (Blueprint $table) {
            $table->id();
            $table->date('data_prescricao');
            $table->text('observacoes');
            $table->text('dosagem');
            $table->text('medicamentos');
            $table->unsignedBigInteger('consulta_id');
            $table->timestamps();

            $table->foreign('consulta_id')->references('id')->on('consultas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('prescricoes');
    }
};

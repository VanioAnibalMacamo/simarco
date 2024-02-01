<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSintomasTable extends Migration
{
    public function up()
    {
        Schema::create('sintomas', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->string('duracao');
            $table->foreignId('consulta_id')->constrained(); // Adicionando a chave estrangeira para consulta
            $table->foreignId('gravidade_id')->constrained(); // Adicionando a chave estrangeira para gravidade
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sintomas');
    }
}

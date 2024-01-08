<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicosTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('medicos')) {
            Schema::create('medicos', function (Blueprint $table) {
                $table->id();
                $table->string('nome');
                $table->unsignedBigInteger('especialidade_id'); // Chave estrangeira
                $table->string('numero_identificacao');
                $table->string('disponibilidade');
                $table->timestamps();

                // Definindo a chave estrangeira
                $table->foreign('especialidade_id')->references('id')->on('especialidades')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('medicos');
    }
}


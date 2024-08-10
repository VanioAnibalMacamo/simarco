<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendamentoDisponibilidadeTable extends Migration
{
    public function up()
    {
        Schema::create('agendamento_disponibilidade', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agendamento_id')->constrained()->onDelete('cascade');
            $table->foreignId('disponibilidade_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('agendamento_disponibilidade');
    }
}

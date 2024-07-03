<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('disponibilidades', function (Blueprint $table) {
            $table->enum('dia_semana', ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta'])->after('id');
            $table->time('hora_inicio')->after('dia_semana');
            $table->time('hora_fim')->after('hora_inicio');
            $table->enum('estado', ['Activa', 'Inactiva'])->after('hora_fim');
            $table->foreignId('medico_id')->constrained()->onDelete('cascade')->after('estado');
        });
    }

    public function down()
    {
        Schema::table('disponibilidades', function (Blueprint $table) {
            $table->dropColumn(['dia_semana', 'hora_inicio', 'hora_fim', 'estado', 'medico_id']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('agendamentos', function (Blueprint $table) {
            // Altera o tipo da coluna 'horario' para 'TIME'
            $table->time('horario')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agendamentos', function (Blueprint $table) {
            // Reverte a mudança, ajustando o tipo da coluna se necessário
            $table->string('horario')->change(); // Ajuste conforme o tipo original
        });
    }
};

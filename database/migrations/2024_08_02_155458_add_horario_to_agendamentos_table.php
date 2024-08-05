<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHorarioToAgendamentosTable extends Migration
{
    /**
     * Execute a migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agendamentos', function (Blueprint $table) {
            $table->string('horario')->after('dia'); // Adiciona a coluna 'horario' após a coluna 'dia'
        });
    }

    /**
     * Revert a migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agendamentos', function (Blueprint $table) {
            $table->dropColumn('horario'); // Remove a coluna 'horario'
        });
    }
}

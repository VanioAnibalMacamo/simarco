<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Defina um valor padrão, como '00:00:00', para os registros com valores inválidos ou vazios
        DB::table('agendamentos')->whereNull('horario')->orWhere('horario', '')->update(['horario' => '00:00:00']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Reverte a mudança, se necessário
        DB::table('agendamentos')->where('horario', '00:00:00')->update(['horario' => null]);
    }
};

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
        Schema::table('consultas', function (Blueprint $table) {
            $table->dropForeign(['id_medico']);
            $table->dropColumn('id_medico');
            $table->dropForeign(['id_paciente']);
            $table->dropColumn('id_paciente');
        });
    }

    public function down()
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->foreignId('id_medico')->constrained('medicos');
            $table->foreignId('id_paciente')->constrained('pacientes');
        });
    }
};

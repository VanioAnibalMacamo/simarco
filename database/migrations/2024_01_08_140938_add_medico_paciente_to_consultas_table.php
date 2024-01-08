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
            // Adiciona as colunas de médico e paciente como nulas temporariamente
            $table->foreignId('id_medico')->nullable()->constrained('medicos');
            $table->foreignId('id_paciente')->nullable()->constrained('pacientes');
        });
    }

    public function down()
    {
        Schema::table('consultas', function (Blueprint $table) {
            // Reverta as alterações se necessário
            $table->dropForeign(['id_medico']);
            $table->dropForeign(['id_paciente']);
            $table->dropColumn(['id_medico', 'id_paciente']);
        });
    }
};

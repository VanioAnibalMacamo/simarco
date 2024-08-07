<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToEmpresaIdInPacientesTable extends Migration
{
    public function up()
    {
        Schema::table('pacientes', function (Blueprint $table) {
            // Adiciona a chave estrangeira
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('pacientes', function (Blueprint $table) {
            // Remove a chave estrangeira
            $table->dropForeign(['empresa_id']);
        });
    }
}

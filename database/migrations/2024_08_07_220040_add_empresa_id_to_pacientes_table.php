<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmpresaIdToPacientesTable extends Migration
{
    public function up()
    {
        Schema::table('pacientes', function (Blueprint $table) {
           

            // Adiciona a coluna empresa_id
            $table->unsignedBigInteger('empresa_id')->nullable()->after('email');

            // Adiciona a chave estrangeira
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('pacientes', function (Blueprint $table) {
            // Remove a chave estrangeira
            $table->dropForeign(['empresa_id']);

            // Remove a coluna empresa_id
            $table->dropColumn('empresa_id');

            // Adiciona novamente a coluna empresa
            $table->string('empresa')->nullable()->after('email');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveIdStatusFromConsultasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consultas', function (Blueprint $table) {
            // Remover a chave estrangeira
            $table->dropForeign(['id_status']);
            // Remover a coluna
            $table->dropColumn('id_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consultas', function (Blueprint $table) {
            // Adicionar a coluna novamente
            $table->unsignedBigInteger('id_status')->nullable();
            // Adicionar a chave estrangeira novamente
            $table->foreign('id_status')->references('id')->on('status_consultas')->onDelete('cascade');
        });
    }
}

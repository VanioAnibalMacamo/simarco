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
        Schema::table('consultas', function (Blueprint $table) {
            // Adicionar novas colunas para as fotos
            $table->string('foto_1')->nullable();
            $table->string('foto_2')->nullable();

            // Remover a coluna fotos_zip
            $table->dropColumn('fotos_zip');
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
            // Reverter as alterações
            $table->string('fotos_zip')->nullable();
            $table->dropColumn(['foto_1', 'foto_2']);
        });
    }
};

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
            $table->unsignedBigInteger('agendamento_id')->nullable()->after('id');
            $table->foreign('agendamento_id')->references('id')->on('agendamentos')->onDelete('cascade');
        });

        Schema::table('agendamentos', function (Blueprint $table) {
            $table->unsignedBigInteger('consulta_id')->nullable()->after('id');
            $table->foreign('consulta_id')->references('id')->on('consultas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->dropForeign(['agendamento_id']);
            $table->dropColumn('agendamento_id');
        });

        Schema::table('agendamentos', function (Blueprint $table) {
            $table->dropForeign(['consulta_id']);
            $table->dropColumn('consulta_id');
        });
    }
};

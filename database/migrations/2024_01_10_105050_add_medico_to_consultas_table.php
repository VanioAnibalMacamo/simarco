<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddMedicoToConsultasTable extends Migration
{
    public function up()
    {
        // Apaga todos os dados da tabela antes de adicionar a nova coluna
        DB::table('consultas')->truncate();

        Schema::table('consultas', function (Blueprint $table) {
            $table->foreignId('medico_id')->constrained('medicos');
        });
    }

    public function down()
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->dropForeign(['medico_id']);
            $table->dropColumn('medico_id');
        });
    }
};

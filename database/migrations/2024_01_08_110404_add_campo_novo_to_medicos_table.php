<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCampoNovoToMedicosTable  extends Migration
{
    public function up()
    {
        Schema::table('medicos', function (Blueprint $table) {
            $table->string('numero_identificacao')->after('especialidade_id');
        });
    }

    public function down()
    {
        Schema::table('medicos', function (Blueprint $table) {
            $table->dropColumn('numero_identificacao');
        });
    }
}

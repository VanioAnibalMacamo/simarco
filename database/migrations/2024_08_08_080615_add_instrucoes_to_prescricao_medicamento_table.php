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
        Schema::table('prescricao_medicamento', function (Blueprint $table) {
            $table->text('instrucoes')->nullable()->after('dosagem');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('prescricao_medicamento', function (Blueprint $table) {
            $table->dropColumn('instrucoes');
        });
    }
};

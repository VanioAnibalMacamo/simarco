<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('prescricoes', function (Blueprint $table) {
            $table->dropColumn('medicamentos');
        });
    }

    public function down()
    {
        // Se você quiser reverter a remoção, adicione a coluna novamente no método down
        Schema::table('prescricoes', function (Blueprint $table) {
            $table->text('medicamentos');
        });
    }
};

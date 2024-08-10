<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RemoveIdStatusFromConsultasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('consultas', 'id_status')) {
            Schema::table('consultas', function (Blueprint $table) {
                $table->dropColumn('id_status');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasColumn('consultas', 'id_status')) {
            Schema::table('consultas', function (Blueprint $table) {
                $table->unsignedBigInteger('id_status')->nullable();
            });
        }
    }
}

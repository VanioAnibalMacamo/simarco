<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('especialidades', function (Blueprint $table) {
            $table->decimal('preco', 8, 2)->after('descricao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('especialidades', function (Blueprint $table) {
            $table->decimal('preco', 8, 2)->after('descricao');
        });
    }
};

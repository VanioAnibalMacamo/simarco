<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('agendamentos', function (Blueprint $table) {
            $table->enum('forma_pagamento', [
                'Transferencia Bancaria',
                'Apolice',
                'Carteiras Moveis',
            ])->change();
        });
    }
public function down()
    {
        Schema::table('agendamentos', function (Blueprint $table) {
            $table->enum('forma_pagamento', [
                'Cash',
                'Via Seguro de Saude',
                'Via Empresa',
            ])->change();
        });
    }
};

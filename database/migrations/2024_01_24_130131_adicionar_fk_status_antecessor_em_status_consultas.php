<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdicionarFkStatusAntecessorEmStatusConsultas extends Migration
{
    public function up()
    {
        // Verificar se a coluna já existe para evitar conflitos
        if (!Schema::hasColumn('status_consultas', 'status_antecessor_id')) {
            Schema::table('status_consultas', function (Blueprint $table) {
                // Adicionar a coluna status_antecessor_id
                $table->unsignedBigInteger('status_antecessor_id')->nullable();

                // Adicionar a chave estrangeira
                $table->foreign('status_antecessor_id')->references('id')->on('status_consultas');
            });
        }
    }

    public function down()
    {
        // Remover a chave estrangeira e a coluna apenas se existirem
        Schema::table('status_consultas', function (Blueprint $table) {
            $table->dropForeign(['status_antecessor_id']);
            $table->dropColumn('status_antecessor_id');
        });
    }
}

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('disponibilidades', function (Blueprint $table) {
            // Adicionar coluna 'dia_semana' se não existir
            if (!Schema::hasColumn('disponibilidades', 'dia_semana')) {
                $table->enum('dia_semana', ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta'])->after('id');
            }

            // Adicionar coluna 'medico_id' se não existir
            if (!Schema::hasColumn('disponibilidades', 'medico_id')) {
                $table->foreignId('medico_id')->constrained()->onDelete('cascade')->after('estado');
            }

            // Remover as colunas desnecessárias se existirem
            if (Schema::hasColumn('disponibilidades', 'hora_inicio')) {
                $table->dropColumn('hora_inicio');
            }
            if (Schema::hasColumn('disponibilidades', 'hora_fim')) {
                $table->dropColumn('hora_fim');
            }
            if (Schema::hasColumn('disponibilidades', 'estado')) {
                $table->dropColumn('estado');
            }
        });
    }

    public function down()
    {
        Schema::table('disponibilidades', function (Blueprint $table) {
            // Reverter as mudanças, adicionando as colunas removidas
            if (!Schema::hasColumn('disponibilidades', 'hora_inicio')) {
                $table->time('hora_inicio')->after('dia_semana');
            }
            if (!Schema::hasColumn('disponibilidades', 'hora_fim')) {
                $table->time('hora_fim')->after('hora_inicio');
            }
            if (!Schema::hasColumn('disponibilidades', 'estado')) {
                $table->enum('estado', ['Activa', 'Inactiva'])->after('hora_fim');
            }
            
            // A coluna 'medico_id' será re-adicionada se não existir
            if (!Schema::hasColumn('disponibilidades', 'medico_id')) {
                $table->foreignId('medico_id')->constrained()->onDelete('cascade')->after('estado');
            }
            
            // Caso a coluna 'dia_semana' precise ser removida na reversão, adicione essa linha também
            $table->dropColumn('dia_semana');
        });
    }
};

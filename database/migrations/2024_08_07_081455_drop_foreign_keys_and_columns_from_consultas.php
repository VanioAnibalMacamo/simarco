<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
       Schema::table('consultas', function (Blueprint $table) {
           // Remover as chaves estrangeiras
           $table->dropForeign(['id_medico']);
           $table->dropForeign(['id_paciente']);

           // Remover as colunas
           $table->dropColumn(['id_medico', 'id_paciente']);
       });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
       Schema::table('consultas', function (Blueprint $table) {
           // Adicionar de volta as colunas
           $table->unsignedBigInteger('id_medico')->nullable();
           $table->unsignedBigInteger('id_paciente')->nullable();

           // Adicionar de volta as chaves estrangeiras
           $table->foreign('id_medico')->references('id')->on('medicos')->onDelete('set null');
           $table->foreign('id_paciente')->references('id')->on('pacientes')->onDelete('set null');
       });
   }
};

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
        Schema::create('prescricao_medicamento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prescricao_id');
            $table->unsignedBigInteger('medicamento_id');
            $table->string('dosagem'); 
            $table->timestamps();

            $table->foreign('prescricao_id')->references('id')->on('prescricoes')->onDelete('cascade');
            $table->foreign('medicamento_id')->references('id')->on('medicamentos')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescricao_medicamento');
    }
};

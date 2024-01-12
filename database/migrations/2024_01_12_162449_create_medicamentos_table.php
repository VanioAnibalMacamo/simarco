<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicamentosTable extends Migration
{
    public function up()
    {
        Schema::create('medicamentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome_medicamento');
            $table->text('substancias_quimicas');
            $table->foreignId('forma_farmaceutica_id')->constrained('formas_farmaceuticas');
            $table->string('dosagem');
            $table->foreignId('via_administracao_id')->constrained('via_administracaoS');
            $table->foreignId('fabricante_id')->constrained('fabricantes');
            $table->string('numero_registo');
            $table->date('data_fabricacao');
            $table->date('data_validade');
            $table->text('indicacoes');
            $table->text('contraindicacoes');
            $table->text('efeitos_colaterais');
            $table->text('instrucoes_uso');
            $table->text('armazenamento');
            $table->decimal('preco', 10, 2);
            $table->enum('disponibilidade', ['disponivel', 'indisponivel']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medicamentos');
    }
};

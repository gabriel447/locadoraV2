<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('locacoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome_cliente');
            $table->string('nome_filme');
            $table->string('codigo_filme');
            $table->date('data_locacao');
            $table->date('data_devolucao');
            $table->decimal('valor', 8, 2);
            $table->boolean('devolvido')->default(false);
            $table->decimal('valor_multa', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('locacoes');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('historico', function (Blueprint $table) {
            $table->id();
            $table->string('nome_cliente');
            $table->string('nome_filme');
            $table->date('data_locacao');
            $table->date('data_devolucao');
            $table->decimal('valor', 8, 2);
            $table->decimal('multa', 8, 2)->nullable();
            $table->decimal('desconto', 8, 2)->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('historico');
    }
};
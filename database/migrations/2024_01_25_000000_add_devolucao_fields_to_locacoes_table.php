<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDevolucaoFieldsToLocacoesTable extends Migration
{
    public function up()
    {
        Schema::table('locacoes', function (Blueprint $table) {
            $table->boolean('devolvido')->default(false);
            $table->date('data_devolucao_efetiva')->nullable();
            $table->decimal('valor_multa', 8, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::table('locacoes', function (Blueprint $table) {
            $table->dropColumn(['devolvido', 'data_devolucao_efetiva', 'valor_multa']);
        });
    }
}
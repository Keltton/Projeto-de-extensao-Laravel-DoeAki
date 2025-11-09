<?php
// database/migrations/2025_11_09_xxxxxx_add_estoque_and_approval_fields_to_doacoes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('doacoes', function (Blueprint $table) {
            // Primeiro adiciona as colunas básicas
            $table->timestamp('data_aprovacao')->nullable()->after('data_doacao');
            $table->timestamp('data_rejeicao')->nullable()->after('data_aprovacao');
            $table->timestamp('data_entrega')->nullable()->after('data_rejeicao');
            $table->text('motivo_rejeicao')->nullable()->after('data_entrega');
            
            // Depois adiciona as colunas de estoque
            $table->boolean('adicionado_estoque')->default(false)->after('motivo_rejeicao');
            $table->timestamp('data_entrada_estoque')->nullable()->after('adicionado_estoque');
            $table->unsignedBigInteger('aprovado_por')->nullable()->after('data_entrada_estoque');
            
            // Chave estrangeira
            $table->foreign('aprovado_por')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::table('doacoes', function (Blueprint $table) {
            $table->dropForeign(['aprovado_por']);
            $table->dropColumn([
                'data_aprovacao',
                'data_rejeicao', 
                'data_entrega',
                'motivo_rejeicao',
                'adicionado_estoque',
                'data_entrada_estoque',
                'aprovado_por'
            ]);
        });
    }
};
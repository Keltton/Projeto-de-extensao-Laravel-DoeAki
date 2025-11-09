<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('doacoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('item_id');
            $table->integer('quantidade')->default(1);
            $table->enum('condicao', ['novo', 'seminovo', 'usado', 'precisa_reparo'])->default('usado');
            $table->text('descricao')->nullable();
            $table->enum('status', ['pendente', 'aceita', 'rejeitada'])->default('pendente');
            $table->timestamp('data_doacao')->useCurrent();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('itens')->onDelete('cascade');
            
            $table->index(['user_id', 'status']);
            $table->index('data_doacao');
        });
    }

    public function down()
    {
        Schema::dropIfExists('doacoes');
    }
};
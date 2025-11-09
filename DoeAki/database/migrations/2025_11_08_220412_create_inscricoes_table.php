<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inscricoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('evento_id')->constrained()->onDelete('cascade');
            $table->timestamp('data_inscricao')->useCurrent();
            $table->enum('status', ['pendente', 'confirmada', 'cancelada'])->default('confirmada');
            $table->timestamps();

            $table->unique(['user_id', 'evento_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('inscricoes');
    }
};
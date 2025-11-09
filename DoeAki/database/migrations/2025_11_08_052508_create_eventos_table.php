<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id(); // unsignedBigInteger primary key
            $table->unsignedBigInteger('user_id'); // quem criou o evento

            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->timestamp('data_evento');
            $table->string('local');
            
            $table->string('endereco')->nullable();
            $table->string('cidade')->nullable();
            $table->string('estado', 2)->nullable();
            $table->string('cep', 9)->nullable();

            $table->integer('vagas_total')->nullable();
            $table->integer('vagas_disponiveis')->nullable();

            $table->enum('status', ['ativo', 'inativo', 'cancelado'])->default('ativo');
            $table->string('imagem')->nullable();

            $table->timestamps();

            // Foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Indexes
            $table->index('user_id');
            $table->index('status');
            $table->index('data_evento');
        });
    }

    public function down()
    {
        Schema::dropIfExists('eventos');
    }
};

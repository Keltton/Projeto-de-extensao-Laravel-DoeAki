<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Para MySQL
        DB::statement("ALTER TABLE doacoes MODIFY status ENUM('pendente', 'aceita', 'rejeitada', 'entregue') DEFAULT 'pendente'");
        
        // Ou para outros bancos, você pode usar:
        // Schema::table('doacoes', function (Blueprint $table) {
        //     $table->enum('status', ['pendente', 'aceita', 'rejeitada', 'entregue'])->default('pendente')->change();
        // });
    }

    public function down()
    {
        DB::statement("ALTER TABLE doacoes MODIFY status ENUM('pendente', 'aceita', 'rejeitada') DEFAULT 'pendente'");
        
        // Ou para outros bancos:
        // Schema::table('doacoes', function (Blueprint $table) {
        //     $table->enum('status', ['pendente', 'aceita', 'rejeitada'])->default('pendente')->change();
        // });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Atualiza os valores de status para serem consistentes
        DB::table('doacoes')->where('status', 'aprovado')->update(['status' => 'aceita']);
        DB::table('doacoes')->where('status', 'rejeitado')->update(['status' => 'rejeitada']);
        
        // Para garantir que todos os status sejam válidos
        DB::table('doacoes')->whereNotIn('status', ['pendente', 'aceita', 'rejeitada', 'entregue'])
                           ->update(['status' => 'pendente']);
    }

    public function down()
    {
        // Reverte as mudanças se necessário
        DB::table('doacoes')->where('status', 'aceita')->update(['status' => 'aprovado']);
        DB::table('doacoes')->where('status', 'rejeitada')->update(['status' => 'rejeitado']);
    }
};
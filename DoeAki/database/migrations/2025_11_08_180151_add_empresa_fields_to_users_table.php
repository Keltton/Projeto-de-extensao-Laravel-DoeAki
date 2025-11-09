<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('possui_empresa')->default(false)->after('sobre');
            $table->string('empresa_nome')->nullable()->after('possui_empresa');
            $table->string('empresa_cnpj')->nullable()->unique()->after('empresa_nome');
            $table->string('empresa_endereco')->nullable()->after('empresa_cnpj');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['possui_empresa', 'empresa_nome', 'empresa_cnpj', 'empresa_endereco']);
        });
    }
};


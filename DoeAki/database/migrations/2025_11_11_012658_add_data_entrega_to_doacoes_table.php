<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('doacoes', function (Blueprint $table) {
            if (!Schema::hasColumn('doacoes', 'data_entrega')) {
                $table->timestamp('data_entrega')->nullable()->after('entregue');
            }
        });
    }

    public function down()
    {
        Schema::table('doacoes', function (Blueprint $table) {
            if (Schema::hasColumn('doacoes', 'data_entrega')) {
                $table->dropColumn('data_entrega');
            }
        });
    }
};
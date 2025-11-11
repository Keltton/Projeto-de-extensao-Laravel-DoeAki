<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doacoes', function (Blueprint $table) {
            // Adiciona apenas as colunas que não existem
            if (!Schema::hasColumn('doacoes', 'entregue')) {
                $table->boolean('entregue')->default(false)->after('status');
            }

            if (!Schema::hasColumn('doacoes', 'data_entrega')) {
                $afterColumn = Schema::hasColumn('doacoes', 'entregue') ? 'entregue' : null;
                if ($afterColumn) {
                    $table->timestamp('data_entrega')->nullable()->after($afterColumn);
                } else {
                    $table->timestamp('data_entrega')->nullable();
                }
            }

            if (!Schema::hasColumn('doacoes', 'data_aprovacao')) {
                $table->timestamp('data_aprovacao')->nullable()->after('status');
            }

            if (!Schema::hasColumn('doacoes', 'data_rejeicao')) {
                $table->timestamp('data_rejeicao')->nullable()->after('data_aprovacao');
            }

            if (!Schema::hasColumn('doacoes', 'motivo_rejeicao')) {
                $table->text('motivo_rejeicao')->nullable()->after('data_rejeicao');
            }

            if (!Schema::hasColumn('doacoes', 'adicionado_estoque')) {
                $table->boolean('adicionado_estoque')->default(false)->after('motivo_rejeicao');
            }

            if (!Schema::hasColumn('doacoes', 'data_entrada_estoque')) {
                $table->timestamp('data_entrada_estoque')->nullable()->after('adicionado_estoque');
            }

            if (!Schema::hasColumn('doacoes', 'aprovado_por')) {
                $table->unsignedBigInteger('aprovado_por')->nullable()->after('data_entrada_estoque');
                $table->foreign('aprovado_por')
                    ->references('id')
                    ->on('users')
                    ->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('doacoes')) {
            return;
        }

        // 🧩 Verifica e remove FK apenas se existir no banco
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_NAME = 'doacoes'
              AND CONSTRAINT_SCHEMA = DATABASE()
              AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        Schema::table('doacoes', function (Blueprint $table) use ($foreignKeys) {
            foreach ($foreignKeys as $fk) {
                if ($fk->CONSTRAINT_NAME === 'doacoes_aprovado_por_foreign') {
                    $table->dropForeign('doacoes_aprovado_por_foreign');
                }
            }

            $columnsToDrop = [
                'entregue',
                'data_entrega',
                'data_aprovacao',
                'data_rejeicao',
                'motivo_rejeicao',
                'adicionado_estoque',
                'data_entrada_estoque',
                'aprovado_por'
            ];

            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('doacoes', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};

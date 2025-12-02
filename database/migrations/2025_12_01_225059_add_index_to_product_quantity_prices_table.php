<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Verificar se o índice já existe antes de criar
        $indexExists = false;
        try {
            $indexes = \DB::select("SHOW INDEX FROM product_quantity_prices WHERE Key_name = 'pqp_product_qty_idx'");
            $indexExists = count($indexes) > 0;
        } catch (\Exception $e) {
            // Tabela pode não existir ainda
        }

        if (!$indexExists) {
            Schema::table('product_quantity_prices', function (Blueprint $table) {
                $table->index(['product_id', 'min_quantity', 'max_quantity'], 'pqp_product_qty_idx');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_quantity_prices', function (Blueprint $table) {
            $table->dropIndex('pqp_product_qty_idx');
        });
    }
};

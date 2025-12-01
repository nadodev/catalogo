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
        if (!Schema::hasTable('product_quantity_prices')) {
            Schema::create('product_quantity_prices', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained()->cascadeOnDelete();
                $table->integer('min_quantity')->default(1); // Quantidade mínima
                $table->integer('max_quantity')->nullable(); // Quantidade máxima (null = sem limite)
                $table->decimal('price', 10, 2); // Preço para esta faixa
                $table->integer('order')->default(0); // Ordem de exibição
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                
                // Garantir que não haja sobreposição de faixas para o mesmo produto
                $table->index(['product_id', 'min_quantity', 'max_quantity'], 'pqp_product_qty_idx');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_quantity_prices');
    }
};

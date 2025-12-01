<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductQuantityPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'min_quantity',
        'max_quantity',
        'price',
        'order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Verifica se uma quantidade está dentro desta faixa
     */
    public function matchesQuantity(int $quantity): bool
    {
        if ($quantity < $this->min_quantity) {
            return false;
        }

        if ($this->max_quantity === null) {
            return true; // Sem limite máximo
        }

        return $quantity <= $this->max_quantity;
    }

    /**
     * Retorna a descrição da faixa
     */
    public function getRangeDescription(): string
    {
        if ($this->max_quantity === null) {
            return "{$this->min_quantity} ou mais";
        }

        if ($this->min_quantity === $this->max_quantity) {
            return "{$this->min_quantity} unidade(s)";
        }

        return "{$this->min_quantity} a {$this->max_quantity} unidades";
    }
}

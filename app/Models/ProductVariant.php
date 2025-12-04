<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'color_id',
        'size_id',
        'price',
        'stock',
        'sku',
        'image_path',
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

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class);
    }

    public function getPriceDisplay(): string
    {
        if ($this->price !== null) {
            return 'R$ ' . number_format((float) $this->price, 2, ',', '.');
        }

        return $this->product?->getPriceDisplay() ?? 'Sob Consulta';
    }

    /**
     * Retorna a URL completa da imagem da variante
     */
    public function getImageUrlAttribute(): ?string
    {
        if (empty($this->image_path)) {
            return null;
        }

        // Se começar com "products/" ou "variants/", retorna do storage
        if (str_starts_with($this->image_path, 'products/') || str_starts_with($this->image_path, 'variants/')) {
            return asset('storage/'.$this->image_path);
        }

        // Caso padrão: retorna do storage
        return asset('storage/'.$this->image_path);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_path',
        'order',
        'is_primary',
    ];

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Retorna a URL completa da imagem
     */
    public function getUrlAttribute(): string
    {
        // Se não houver image_path, retorna placeholder
        if (empty($this->image_path)) {
            return asset('images/product-placeholder.svg');
        }

        // Se for apenas um nome de arquivo sem caminho (placeholder da factory), retorna do public/images
        if (strpos($this->image_path, '/') === false) {
            return asset('images/'.$this->image_path);
        }

        // Se começar com "products/" ou "categories/", retorna do storage
        if (str_starts_with($this->image_path, 'products/') || str_starts_with($this->image_path, 'categories/')) {
            return asset('storage/'.$this->image_path);
        }

        // Caso padrão: retorna do storage
        return asset('storage/'.$this->image_path);
    }
}

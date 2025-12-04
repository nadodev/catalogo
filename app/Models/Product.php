<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'code',
        'description',
        'specifications',
        'price',
        'show_price',
        'is_active',
        'is_new',
        'is_popular',
        'is_featured',
        'meta_title',
        'meta_description',
        'views_count',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'show_price' => 'boolean',
            'is_active' => 'boolean',
            'is_new' => 'boolean',
            'is_popular' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });

        static::updating(function (Product $product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    public function primaryImage(): ?ProductImage
    {
        return $this->images()->where('is_primary', true)->first();
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class);
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function scopeFeatured(Builder $query): void
    {
        $query->where('is_featured', true);
    }

    public function scopePopular(Builder $query): void
    {
        $query->where('is_popular', true);
    }

    public function scopeNew(Builder $query): void
    {
        $query->where('is_new', true);
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function getRelatedProducts(int $limit = 4): Collection
    {
        return static::query()
            ->where('category_id', $this->category_id)
            ->where('id', '!=', $this->id)
            ->active()
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    public function getPriceDisplay(): string
    {
        if ($this->show_price && $this->price !== null) {
            return 'R$ ' . number_format((float) $this->price, 2, ',', '.');
        }

        return 'Sob Consulta';
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function activeVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class)->where('is_active', true);
    }

    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class, 'product_variants')
            ->wherePivot('is_active', true)
            ->distinct();
    }

    public function sizes(): BelongsToMany
    {
        return $this->belongsToMany(Size::class, 'product_variants')
            ->wherePivot('is_active', true)
            ->distinct();
    }

    public function quantityPrices(): HasMany
    {
        return $this->hasMany(ProductQuantityPrice::class)->where('is_active', true)->orderBy('min_quantity');
    }

    public function allQuantityPrices(): HasMany
    {
        return $this->hasMany(ProductQuantityPrice::class)->orderBy('min_quantity');
    }

    /**
     * Obtém o preço baseado na quantidade
     */
    public function getPriceForQuantity(int $quantity): ?float
    {
        $priceTier = $this->quantityPrices()
            ->where('min_quantity', '<=', $quantity)
            ->where(function ($query) use ($quantity) {
                $query->whereNull('max_quantity')
                    ->orWhere('max_quantity', '>=', $quantity);
            })
            ->orderBy('min_quantity', 'desc')
            ->first();

        if ($priceTier) {
            return (float) $priceTier->price;
        }

        // Se não encontrar faixa específica, retorna o preço padrão
        return $this->price ? (float) $this->price : null;
    }

    /**
     * Verifica se o produto tem estoque disponível
     * Se o produto tem variantes, verifica se pelo menos uma variante tem estoque
     */
    public function hasStock(): bool
    {
        // Se o produto tem variantes, verificar se alguma tem estoque
        if ($this->variants()->where('is_active', true)->count() > 0) {
            // Verificar se pelo menos uma variante tem estoque > 0 ou estoque null (ilimitado)
            $hasStock = $this->variants()
                ->where('is_active', true)
                ->where(function ($query) {
                    $query->whereNull('stock')
                        ->orWhere('stock', '>', 0);
                })
                ->exists();
            
            return $hasStock;
        }

        // Se não tem variantes, considerar que tem estoque (produto sem controle de estoque)
        // Ou você pode adicionar um campo stock no produto se necessário
        return true;
    }

    /**
     * Verifica se uma variante específica tem estoque disponível
     */
    public function hasVariantStock(?int $colorId = null, ?int $sizeId = null): bool
    {
        if ($colorId === null && $sizeId === null) {
            return $this->hasStock();
        }

        $variant = $this->variants()
            ->where('is_active', true)
            ->when($colorId !== null, function ($query) use ($colorId) {
                return $query->where('color_id', $colorId);
            })
            ->when($sizeId !== null, function ($query) use ($sizeId) {
                return $query->where('size_id', $sizeId);
            })
            ->first();

        if (!$variant) {
            return false;
        }

        // Se stock é null, considera estoque ilimitado
        if ($variant->stock === null) {
            return true;
        }

        return $variant->stock > 0;
    }

    /**
     * Obtém o estoque total do produto (soma de todas as variantes)
     */
    public function getTotalStock(): ?int
    {
        if ($this->variants()->where('is_active', true)->count() === 0) {
            return null; // Sem controle de estoque
        }

        $totalStock = $this->variants()
            ->where('is_active', true)
            ->whereNotNull('stock')
            ->sum('stock');

        return $totalStock > 0 ? (int) $totalStock : 0;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
        'published_at',
        'price',
        'compare_at_price',
        'stock_quantity',
        'sku',
        'images',
        'weight',
        'dimensions',
        'is_active',
        'status',
        'moderation_status',
        'moderation_reason',
        'category_id',
        'user_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'images' => 'array',
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_ARCHIVED = 'archived';
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function likes()
    {
        return $this->hasMany(ProductLike::class);
    }
    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('status', self::STATUS_PUBLISHED);
    }

    public function scopeApproved($query)
    {
        return $query->where('moderation_status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('moderation_status', 'pending');
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED)
            ->where('is_active', true);
    }
    public function getPrimaryImageAttribute(): ?string
    {
        $images = is_array($this->images) ? $this->images : [];

        foreach ($images as $image) {
            $normalized = $this->normalizeImageReference($image);
            if ($normalized !== null) {
                return $normalized;
            }
        }

        return null;
    }

    private function normalizeImageReference(mixed $image): ?string
    {
        if (!is_string($image)) {
            return null;
        }

        $value = trim($image);
        if ($value === '') {
            return null;
        }

        if (filter_var($value, FILTER_VALIDATE_URL)) {
            $path = parse_url($value, PHP_URL_PATH);
            if (is_string($path) && str_starts_with($path, '/storage/')) {
                return $path;
            }

            return $value;
        }

        if (str_starts_with($value, '/storage/')) {
            return $value;
        }

        if (str_starts_with($value, 'storage/')) {
            return '/' . ltrim($value, '/');
        }

        if (str_starts_with($value, 'products/')) {
            return Storage::disk('public')->url($value);
        }

        return null;
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->approved()->avg('rating') ?? 0;
    }

    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->approved()->count();
    }

    public function getTotalLikesAttribute()
    {
        return $this->likes()->count();
    }

    public function isLikedByUser($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }
}

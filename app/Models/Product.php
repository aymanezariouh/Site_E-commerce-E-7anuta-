<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    // Relationships
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

    // Scopes
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

    // Helper methods
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment',
        'is_approved',
        'moderation_status',
        'moderation_reason',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function scopeApproved($query)
    {
        return $query->where('moderation_status', 'approved');
    }

    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }
}

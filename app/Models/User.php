<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'string',
            'suspended_at' => 'datetime',
        ];
    }

    // Relationships
    public function products()
    {
        return $this->hasMany(Product::class); // for vendors
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function likes()
    {
        return $this->hasMany(ProductLike::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->hasRole('admin') || $this->role === 'admin';
    }

    public function isModerator()
    {
        return $this->hasRole('moderator') || $this->role === 'moderator';
    }

    public function isSeller()
    {
        return $this->hasRole('seller') || $this->role === 'seller';
    }

    public function isBuyer()
    {
        return $this->hasRole('buyer') || $this->role === 'buyer';
    }

    public function isSuspended(): bool
    {
        return (bool) $this->suspended_at;
    }

    // Equivalent of: hasPermission(p: Permission): bool
    public function hasPermission($permission): bool
    {
        return $this->can($permission);
    }
}

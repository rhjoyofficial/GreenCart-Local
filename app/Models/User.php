<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'business_name',
        'phone',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'postal_code',
        'country',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class, 'customer_id');
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'customer_id');
    }

    public function defaultWishlist(): HasOne
    {
        return $this->hasOne(Wishlist::class, 'customer_id')->where('is_default', true);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function sellerOrders(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'seller_id');
    }

    public function passwordResets(): HasMany
    {
        return $this->hasMany(PasswordReset::class);
    }

    // Helper methods for role checking
    public function hasRole(string $role): bool
    {
        return $this->role?->slug === $role;
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function getDashboardRoute(): string
    {
        return match (true) {
            $this->hasRole('admin')    => route('admin.dashboard'),
            $this->hasRole('seller')   => route('seller.dashboard'),
            $this->hasRole('customer') => route('customer.dashboard'),
            default                    => route('home'),
        };
    }
}

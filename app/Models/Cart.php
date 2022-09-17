<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    } 
    /**
     * Get all of the cart items for the Cart
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cart_items()
    {
        return $this->hasMany(CartItem::class);
    }
}

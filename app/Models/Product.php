<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'price',
        'store_id',
        'is_vat_included',
    ];
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    /**
     * Get all of the cart_items for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cart_items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}

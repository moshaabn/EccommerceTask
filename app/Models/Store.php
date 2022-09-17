<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'vat',
        'shipping_cost',
        'merchant_id',
    ];
    public function merchant()
    {
        return $this->belongsTo(User::class, 'merchant_id', 'id');
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'total_price',
        'status',
        'catched_at',
        'delivered_at',
        'user_id',
    ];
    public function merchant()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

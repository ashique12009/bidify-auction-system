<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'publisher_id',
        'product_name',
        'description',
        'product_image',
        'status',
        'start_price',
        'current_price',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'start_price' => 'decimal:2',
        'current_price' => 'decimal:2',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function publisher()
    {
        return $this->belongsTo(User::class, 'publisher_id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class)->orderBy('created_at', 'desc');
    }
}

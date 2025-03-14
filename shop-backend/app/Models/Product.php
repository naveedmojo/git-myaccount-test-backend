<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'category_id', 'price', 'stock', 'description', 'image'
    ];

    // Define the relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Accessor to get full image URL
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image);
    }
}

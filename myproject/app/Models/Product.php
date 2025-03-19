<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'sub_category_id',
        'image', 'is_sold', 'type', 'years_used'
    ];

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}

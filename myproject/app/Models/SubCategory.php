<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{

    protected $fillable = ['name', 'main_category_id', 'stock', 'description', 'image'];

    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class);
    }
    public function products()
    {
    return $this->hasMany(Product::class);
    }

}

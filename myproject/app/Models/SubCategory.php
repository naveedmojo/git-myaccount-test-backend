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

    /**
     * Get all subcategories as JSON.
     */
    public static function getAllSubCategories()
    {
        return response()->json(self::all());
    }

    /**
     * Get the total count of subcategories as JSON.
     */
    public static function getTotalSubCategories()
    {
        return response()->json(['total_sub_categories' => self::count()]);
    }

    /**
     * Get the main category by subcategory ID as JSON.
     */
    public static function getMainCategoryById($id)
    {
        $subCategory = self::with('mainCategory')->find($id);

        if (!$subCategory) {
            return response()->json(['message' => 'Subcategory not found'], 404);
        }

        return response()->json($subCategory->mainCategory);
    }

}

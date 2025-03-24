<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
   

    protected $fillable = ['name', 'description', 'image'];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    /**
     * Get all main categories as JSON.
     */
    public static function getAllMainCategories()
    {
        return response()->json(self::all());
    }

    /**
     * Get the total count of main categories as JSON.
     */
    public static function getTotalMainCategories()
    {
        return response()->json(['total_main_categories' => self::count()]);
    }

    /**
     * Get subcategories by main category ID as JSON.
     */
    public static function getSubCategoriesById($id)
    {
        $category = self::with('subCategories')->find($id);

        if (!$category) {
            return response()->json(['message' => 'Main category not found'], 404);
        }

        return response()->json($category->subCategories);
    }
    
}

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
    
}

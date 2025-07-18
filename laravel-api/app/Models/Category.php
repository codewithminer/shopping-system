<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'parent_id'];

    public function products(): HasMany{
        return $this->hasMany(Product::class);
    }

    // A category can have one parent category. 
    //for example, 'Electronics' is a parent category of 'Smartphones'.
    public function parent(): BelongsTo{
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // A category can have many child categories.
    // for example, 'Smartphones' and 'Computers' are child categories of 'Electronics'.
    public function children(): HasMany{
        return $this->hasMany(Category::class, 'parent_id');
    }
    
    
    
}

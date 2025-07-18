<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock_quantity',
        'sku',
        'category_id',
        'is_active',
        'images', // Assuming JSON
        'attributes' // Assuming JSON
        
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'images' => 'array',
        'attributes' => 'array',
        'price' => 'decimal:2',
    ];

    /**
     * Get the category that owns the Product.
     * A Product belongs to one Category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // A product can have many categories.
    // for ex. 'Graphic cards' belongs to 'Computers' and 'Electronics' category. 
    public function categories(): BelongsToMany{
        return $this->belongsToMany(Category::class);
    }

    public function comment(): HasMany{
        return $this->hasMany(Comment::class);
    }
}

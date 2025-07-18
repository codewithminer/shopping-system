<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'shipping_address',
        'billing_address',
        'payment_method',
        'payment_status'
    ];

    protected $casts = [
        'shipping_address' => 'array',
        'billing_address' => 'array',
        'total_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

        /**
     * Get all of the items for the Order.
     * An Order is composed of many OrderItems.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

 /**
     * Defines the many-to-many relationship between an Order and its Products.
     *
     * This relationship uses the `belongsToMany` method because a single order can
     * contain multiple products, and a single product can appear in multiple
     * different orders over time.
     *
     * A direct `hasMany` relationship is not suitable here, as it would imply a
     * one-to-many connection where a product could only belong to a single order.
     *
     * The connection is established through the `order_items` pivot table. This
     * intermediate table is essential for two reasons:
     * 1. It resolves the many-to-many connection, which is impossible to model
     * directly in a relational database (i.e., you cannot store multiple
     * product IDs in a single column on the orders table).
     * if  we wanted to establish this relationship directly,
     * we would face a fundamental problem: 
     * In the Orders table, we would need a column named product_id. 
     * But if an order includes 3 products, 
     * what value would we put in this column? 1, 5, 12? 
     * This is impossible because a column can only accept a single value.
     * 2. It stores crucial information specific to this relationship, such as the
     * `quantity` and the `price_at_purchase` for each product in this order,
     * which is made accessible via the `withPivot()` method.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_items')
                    ->withPivot('quantity', 'price_at_purchase')
                    ->withTimestamps();
    }

    /**
     * Get all of the payments for the Order.
     * An Order can have many Payments (e.g., multiple attempts).
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}

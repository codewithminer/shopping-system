<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Seeding Users...');
        // 1. create a specific Admin user for easy login
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

         // 2. Create a specific regular user for testing
         $testUser = User::factory()->create([
        'name' => 'Test User',
        'email' => 'user@example.com',
        'password' => Hash::make('password'),
        'role' => 'user',
        ]);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $otherUsers = User::factory(10)->create();
        $allUsers = $otherUsers->merge([$admin, $testUser]);

        // 2. Create Categories & Products
        $this->command->info('Seeding Categories and Products...');
        $categories = Category::factory(5)->create();
        $products = Product::factory(50)->recycle($categories)->create();//recycle() tells the factory: "For the category_id, don't create a new one. Instead, randomly pick one from the existing 

        // 3. Create Orders, OrderItems, and Payments
        $this->command->info('Seeding Orders, Order Items, and Payments...');
        foreach ($allUsers as $user) {
            Order::factory(rand(1, 5))->create(['user_id' => $user->id])->each(function (Order $order) use ($products) {
                $productsToAttach = $products->random(rand(1, 4));
                $totalPrice = 0;

                // Create OrderItems
                foreach ($productsToAttach as $product) {
                    $quantity = rand(1, 3);
                    $totalPrice += $quantity * $product->price;
                    $order->items()->create([
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price_at_purchase' => $product->price,
                    ]);
                }

                // Update order total and payment status
                $order->total_price = $totalPrice;
                $order->payment_status = 'paid';
                $order->save();

                // Create a corresponding Payment
                Payment::factory()->create([
                    'order_id' => $order->id,
                    'amount' => $order->total_price,
                ]);
            });
        }

        // 4. Create Comments/Reviews
        $this->command->info('Seeding Comments...');
        foreach ($products as $product) {
            Comment::factory(rand(0, 5))->create([
                'product_id' => $product->id,
                'user_id' => $allUsers->random()->id,
            ]);
        }

        $this->command->info('Database seeding completed successfully!');

    }
}

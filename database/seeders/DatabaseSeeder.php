<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\City;
use App\Models\Color;
use App\Models\Copouns;
use App\Models\Country;
use App\Models\Governorate;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Rate;
use App\Models\Region;
use App\Models\Review;
use App\Models\Role;
use App\Models\Size;
use App\Models\User;
use App\Models\Zipcode;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Size::factory()->count(3)->create();
        Color::factory()->count(3)->create();
        Country::factory()->count(50)->create();
        City::factory()->count(10)->create();
        Governorate::factory()->count(3)->create();
        Region::factory()->count(3)->create();
        Zipcode::factory()->count(10)->create();
        Copouns::factory()->count(14)->create();
        Address::factory()->count(3)->create();
        Role::factory()->count(5)->create();
        User::factory()->count(2)->create();

        Category::factory()
        ->count(8)
        ->create()
        ->each(function ($category) {
            Product::factory()->count(5)->create([
                'category_id' => $category->id,
            ]);
        });

        Cart::factory()->count(2)->create()
        ->each(function ($Cart){
            CartItem::factory()->count(3)->create([
                'cart_id'=>$Cart->id,
                'product_id'=>Product::factory(),
                'color_id'=>Color::factory(),
                'size_id'=>Size::factory()
            ]);
        });

        Order::factory()->count(3)->create()
        ->each(function ($Order){
            OrderItem::factory()->count(3)->create(
                [
                    'order_id'=>$Order->id,
                    'product_id'=>Product::factory(),
                    'category_id'=>Category::factory()
                ]
                );
        });

        Notification::Factory()->count(10)->create();
        Rate::factory()->count(5)->create();
        Review::factory()->count(5)->create();
        




    }
}

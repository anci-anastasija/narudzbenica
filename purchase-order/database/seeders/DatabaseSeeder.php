<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Supplier;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Product::truncate();        
        Order::truncate();        
        User::truncate();        
        Supplier::truncate();  

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        $supplier1 = Supplier::factory()->create();
        $supplier2 = Supplier::factory()->create();

        Order::factory(3)->create([
            'user_id'=>$user1->id,
            'supplier_id'=>$supplier1->id,
        ]);

        Order::factory()->create([
            'user_id'=>$user2->id,
            'supplier_id'=>$supplier2->id,
        ]);

        Order::factory()->create([
            'user_id'=>$user3->id,
            'supplier_id'=>$supplier1->id,
        ]);

    }
}

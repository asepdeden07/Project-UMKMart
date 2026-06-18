<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::factory()->admin()->create([
            'name' => 'Admin UMKMart',
            'email' => 'admin@umkmart.test',
        ]);

        

        $this->command->info('✅ Database seeding completed successfully!');
        $this->command->info('Admin User: admin@umkmart.test (password: password)');
       
    }
}


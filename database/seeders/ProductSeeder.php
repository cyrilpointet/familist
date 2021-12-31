<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::truncate();

        for ($i=0; $i<5; $i++) {
            Product::create([
                'name' => 'Product ' . ($i),
                'todolist_id' => 1,
            ]);
        }
    }
}

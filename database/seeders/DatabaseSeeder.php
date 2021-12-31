<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('todolists_users')->truncate();
        $this->call(UserSeeder::class);
        $this->call(TodolistSeeder::class);
        $this->call(ProductSeeder::class);
        Schema::enableForeignKeyConstraints();
    }
}

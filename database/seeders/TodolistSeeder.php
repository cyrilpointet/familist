<?php

namespace Database\Seeders;

use App\Models\Todolist;
use Illuminate\Database\Seeder;

class TodolistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Todolist::truncate();
        $todolist = Todolist::create([
            'name' => 'test todolist'
        ]);
        $todolist->users()->attach(1);
        $todolist->users()->attach(2);
        $todolist->users()->attach(3);
        $todolist->save();
    }
}

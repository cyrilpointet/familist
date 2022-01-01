<?php

namespace Database\Seeders;

use App\Models\Invitation;
use Illuminate\Database\Seeder;

class InvitationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Invitation::truncate();

        Invitation::create([
            'email' => "tutu@tutu.tutu",
            'todolist_id' => 1,
        ]);
    }
}

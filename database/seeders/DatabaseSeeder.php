<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Expense;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::factory(10)->create();

        $users->push(\App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]));

        $users->each(function ($user) {
            Expense::factory(rand(0, 10))->create(['owner_id' => $user->id]);
        });
    }
}

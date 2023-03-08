<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Todolist;
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
        // \App\Models\User::factory(15)->create();

        // User::factory()->create([
        //     'name' => 'Aung Khine Phyo',
        //     'email' => 'aungkhinephyo528@gmail.com',
        //     'phone' => '09778997079',
        //     'job' => 'Freelancer',
        //     'password' => bcrypt(123123123),
        // ]);

        \App\Models\Todolist::factory(50)->create();


    }
}

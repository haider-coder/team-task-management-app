<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
             [
                       'name'=>'Admin User',
                       'email'=>'admin@admin.com',
                       'type'=>1,
                       'password'=> bcrypt('123456'),
                    ],
                    [
                       'name'=>'Manager User',
                       'email'=>'manager@manager.com',
                       'type'=> 2,
                       'password'=> bcrypt('123456'),
                    ],
                    [
                       'name'=>'User',
                       'email'=>'user@user.com',
                       'type'=>0,
                       'password'=> bcrypt('123456'),
                    ],
         ]);
    }
}

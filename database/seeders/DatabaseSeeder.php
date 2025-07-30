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
      \App\Models\User::insert([
         'name'=>'Haider Majeed',
         'email'=>'haiderjuttearner@gmail.com',
         'type'=>1,
         'password'=> bcrypt('jutt007'),
      ]);

      \App\Models\Tag::insert([
         'name'=>'Gen',
         'created_at' => now(),
         'updated_at' => now(),
      ]);
      \App\Models\Tag::insert([
         'name'=>'Edu',
         'created_at' => now(),
         'updated_at' => now(),
      ]);
      \App\Models\Tag::insert([
         'name'=>'Stu',
         'created_at' => now(),
         'updated_at' => now(),
      ]);
    }
}

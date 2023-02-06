<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tags;
use App\Models\Company;
use App\Models\JobList;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            // 'password' => 'admin123',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'testuser',
            'email' => 'testuser@gmail.com',
            'password' => Hash::make('user123'),
            // 'password' => 'user123',
        ]);

        JobList::factory(10)->create();
        Company::factory(10)->create();

    }
}

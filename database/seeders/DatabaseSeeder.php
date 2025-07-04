<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Test user',
            'password' => bcrypt('123456'),
            'email' => 'test@gmail.com',
            'role' => 'admin'
        ]);

        $this->call([
            CrudSeeder::class,
            MenuSeeder::class,
            TaskSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            AttributeSeeder::class,
            AttributeValueSeeder::class,
        ]);
    }
}

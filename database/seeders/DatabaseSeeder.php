<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $super = User::create([
            'name' => 'Test user',
            'password' => bcrypt('123456'),
            'email' => 'test@gmail.com',
            'role' => 'admin',
          ]);

        $roleSuperAdmin = Role::create(['name' => 'admin']);
        $super->assignRole(['admin']);

        $this->call([
            CrudSeeder::class,
            MenuSeeder::class,
            TaskSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            AttributeSeeder::class,
            AttributeValueSeeder::class,
            BlogSeeder::class,
            FormSeeder::class,
            PageSeeder::class,
            PaymentGatewaySeeder::class,
        ]);
    }
}

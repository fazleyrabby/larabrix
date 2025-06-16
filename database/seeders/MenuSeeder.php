<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menu = new Menu();
        $menu->title = 'Home';
        $menu->slug = 'home';
        $menu->parent_id = 0;
        $menu->status = 'active';
        $menu->href = '/';
        $menu->status = true;
        $menu->position = 0;
        $menu->save();

        $menu = new Menu();
        $menu->title = 'Test Parent';
        $menu->slug = 'test-parent';
        $menu->parent_id = 0;
        $menu->status = 'active';
        $menu->href = '/';
        $menu->status = true;
        $menu->position = 1;
        $menu->save();

        $menu = new Menu();
        $menu->title = 'Test Child';
        $menu->slug = 'test-child';
        $menu->parent_id = 2;
        $menu->status = 'active';
        $menu->href = '/';
        $menu->status = true;
        $menu->position = 2;
        $menu->save();

        $menu = new Menu();
        $menu->title = 'Products';
        $menu->slug = 'products';
        $menu->parent_id = 0;
        $menu->status = 'active';
        $menu->href = '/products';
        $menu->status = true;
        $menu->position = 3;
        $menu->save();
    }
}

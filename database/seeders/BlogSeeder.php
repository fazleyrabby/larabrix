<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Term;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [];
        for ($i = 1; $i <= 10; $i++) {
            $tags[] = Term::create([
                'type' => 'tag',
                'value' => 'Tag ' . $i,
            ]);
        }

        // Create blogs using factory
        Blog::factory()
            ->count(20)
            ->create()
            ->each(function ($blog) use ($tags) {
                // Attach 1-3 random tags per blog
                $blog->terms()->attach(
                    collect($tags)->random(rand(1, 3))->pluck('id')->toArray()
                );
            });
    }
}

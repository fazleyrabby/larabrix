<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PageFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->sentence(3);
        $hasPageBuilder = $this->faker->boolean(); // random true/false

        return [
            'title'           => $title,
            'slug'            => Str::slug($title),
            'status'          => $this->faker->boolean(),
            'template'        => $this->faker->randomElement(['default', 'form', 'landing', 'blog-index', 'blog-single']),
            'has_page_builder' => $hasPageBuilder,
            'content'         => $hasPageBuilder
                ? null // if builder enabled, leave content null
                : collect($this->faker->paragraphs(3))
                ->map(fn($p) => "## " . $this->faker->words(2, true) . "\n" . $p)
                ->implode("\n\n"),
            'builder'         => $hasPageBuilder
                ? json_encode([
                    [
                        'id' => 'hero' . '-' . now()->timestamp . '-' . rand(100, 999),
                        'type' => 'hero',
                        'props' => [
                            'heading' => ['type' => 'text', 'value' => $this->faker->sentence()],
                            'subheading' => ['type' => 'textarea', 'value' => $this->faker->sentence()],
                            'button_text' => ['type' => 'text', 'value' => 'Get Started'],
                            'background_image' => ['type' => 'image', 'value' => null],
                        ],
                    ],
                    [
                        'id' => 'features' . '-' . now()->timestamp . '-' . rand(100, 999),
                        'type' => 'features',
                        'props' => [
                            'items' => [
                                'type' => 'repeater',
                                'fields' => [
                                    'title' => ['type' => 'text'],
                                    'description' => ['type' => 'textarea'],
                                ],
                                'value' => [
                                    ['title' => 'Modular', 'description' => 'Use only what you need'],
                                    ['title' => 'Blade-based', 'description' => 'Lightweight and fast'],
                                    ['title' => 'Open Source', 'description' => 'MIT licensed'],
                                ],
                            ],
                        ],
                    ],
                    [
                        'id' => 'blogs' . '-' . now()->timestamp . '-' . rand(100, 999),
                        'type' => 'blogs',
                        'props' => [
                            'heading' => ['type' => 'text', 'value' => 'Latest Blog Posts'],
                            'limit' => ['type' => 'number', 'value' => 3],
                            'sort' => ['type' => 'select', 'value' => 'desc'],
                        ],
                    ],
                ])
                : null, // if no builder, keep null
        ];
    }
}

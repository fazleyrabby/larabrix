<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Page>
 */
class PageFactory extends Factory
{
    protected $model = Page::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(3);

        return [
            'title'     => $title,
            'slug'      => Str::slug($title),
            'content'   => collect($this->faker->paragraphs(2))
                ->map(fn($p) => "## " . $this->faker->words(2, true) . "\n" . $p)
                ->implode("\n\n"),
            'status'    => $this->faker->boolean(),
            'template'  => $this->faker->randomElement(['default', 'form', 'landing', 'blog-index', 'blog-single']),
            'builder'   => json_encode([
                [
                    'type' => 'hero',
                    'props' => [
                        'heading' => $this->faker->sentence(),
                        'subheading' => $this->faker->sentence(),
                        'button_text' => 'Get Started',
                    ],
                ],
                [
                    'type' => 'features',
                    'props' => [
                        'items' => [
                            ['title' => 'Fast', 'description' => 'Super fast performance'],
                            ['title' => 'Secure', 'description' => 'Built with security in mind'],
                        ],
                    ],
                ],
            ]),
        ];
    }
}

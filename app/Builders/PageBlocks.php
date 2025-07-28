<?php

namespace App\Builders;

class PageBlocks
{
    public static function all(): array
    {
        return [
            'hero' => [
                'label' => 'Hero Section',
                'description' => 'Big title, subtitle and call-to-action button',
                'props' => [
                    'title' => 'Welcome to Larabrix!',
                    'subtitle' => 'Build pages visually with ease.',
                    'button_text' => 'Get Started',
                    'button_url' => '#',
                    'background_image' => null,
                ],
            ],
            'intro' => [
                'label' => 'Intro Section',
                'description' => 'Short text-based introduction',
                'props' => [
                    'heading' => 'About Us',
                    'content' => 'We provide scalable Laravel components for developers.',
                    'image' => null,
                ],
            ],
            'features' => [
                'label' => 'Feature Grid',
                'description' => 'Highlight key features in grid format',
                'props' => [
                    'heading' => 'Our Features',
                    'items' => [
                        ['title' => 'Modular', 'description' => 'Use only what you need'],
                        ['title' => 'Blade-based', 'description' => 'Lightweight and fast'],
                        ['title' => 'Open Source', 'description' => 'MIT licensed'],
                    ],
                ],
            ],
            'call_to_action' => [
                'label' => 'Call to Action',
                'description' => 'Centered CTA block with button',
                'props' => [
                    'text' => 'Ready to build your next project?',
                    'button_text' => 'Explore Larabrix',
                    'button_url' => '/docs',
                ],
            ],
            'testimonial' => [
                'label' => 'Testimonials',
                'description' => 'Customer feedback carousel or grid',
                'props' => [
                    'heading' => 'What People Say',
                    'testimonials' => [
                        ['name' => 'John Doe', 'quote' => 'Best modular toolkit ever!'],
                        ['name' => 'Jane Smith', 'quote' => 'I love how simple it is.'],
                    ],
                ],
            ],
            'blogs' => [
                'label' => 'Latest Blog Posts',
                'description' => 'Display recent blog entries',
                'props' => [
                    'heading' => 'From the Blog',
                    'limit' => 3,
                ],
            ],
            'form' => [
                'label' => 'Custom Form',
                'description' => 'Embed a form builder form',
                'props' => [
                    'form_id' => null,
                    'title' => 'Contact Us',
                ],
            ],
            'faq' => [
                'label' => 'FAQ',
                'description' => 'Frequently asked questions',
                'props' => [
                    'heading' => 'Common Questions',
                    'items' => [
                        ['question' => 'Is Larabrix open source?', 'answer' => 'Yes! MIT licensed.'],
                        ['question' => 'Does it support Livewire?', 'answer' => 'Absolutely.'],
                    ],
                ],
            ],
        ];
    }

    public static function get(string $type): ?array
    {
        return self::all()[$type] ?? null;
    }

    public static function make(array $block): ?object
    {
        if (!isset($block['type'])) {
            return null;
        }

        $definition = self::get($block['type']);

        if (!$definition) {
            return null;
        }

        return (object)[
            'id' => $block['id'] ?? $block['type'] . '-' . now()->timestamp . '-' . rand(0, 999),
            'type' => $block['type'],
            'label' => $definition['label'],
            'description' => $definition['description'],
            'props' => array_merge($definition['props'], $block['props'] ?? []),
        ];
    }

    public static function exists(string $type): bool
    {
        return array_key_exists($type, self::all());
    }

    public static function labels(): array
    {
        return collect(self::all())->mapWithKeys(fn($block, $key) => [$key => $block['label']])->toArray();
    }
}

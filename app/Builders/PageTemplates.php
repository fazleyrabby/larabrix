<?php

namespace App\Builders;

class PageTemplates
{
    public static function all(): array
    {
        return [
            'landing' => [
                'label' => 'Landing Page',
                'description' => 'A standard landing page with hero, features, testimonials, and CTA.',
                'blocks' => [
                    'hero',
                    'features',
                    'testimonial',
                    'call_to_action',
                ],
            ],
            'about' => [
                'label' => 'About Page',
                'description' => 'A page to introduce your team or project.',
                'blocks' => [
                    'intro',
                    'features',
                    'testimonial',
                ],
            ],
            'contact' => [
                'label' => 'Contact Page',
                'description' => 'A simple contact form page.',
                'blocks' => [
                    'intro',
                    'form',
                    'faq',
                ],
            ],
            'blog' => [
                'label' => 'Blog Listing Page',
                'description' => 'A page to show latest blog posts.',
                'blocks' => [
                    'intro',
                    'blogs',
                ],
            ],
            'default' => [
                'label' => 'Default Page',
                'description' => 'A clean template with only one intro block.',
                'blocks' => [
                    'intro',
                ],
            ],
        ];
    }

    public static function get(string $key): ?array
    {
        return self::all()[$key] ?? null;
    }

    public static function exists(string $key): bool
    {
        return array_key_exists($key, self::all());
    }

    public static function labels(): array
    {
        return collect(self::all())->mapWithKeys(fn($tpl, $key) => [$key => $tpl['label']])->toArray();
    }
}
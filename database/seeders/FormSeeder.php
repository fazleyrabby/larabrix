<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Form;
use App\Models\FormField;

class FormSeeder extends Seeder
{
    public function run()
    {
        // First Form: Contact Form
        $contactForm = Form::create(['name' => 'Contact Form']);

        $contactForm->formFields()->createMany([
            [
                'type' => 'text',
                'label' => 'Full Name',
                'name' => 'full_name',
                'placeholder' => 'Enter your full name',
                'options' => [], // No options needed
                'validation' => ['required'],
                'order' => 1,
            ],
            [
                'type' => 'email',
                'label' => 'Email',
                'name' => 'email',
                'placeholder' => 'you@example.com',
                'options' => [],
                'validation' => ['required', 'email'],
                'order' => 2,
            ],
            [
                'type' => 'textarea',
                'label' => 'Message',
                'name' => 'message',
                'placeholder' => 'Write your message...',
                'options' => [],
                'validation' => ['required'],
                'order' => 3,
            ],
        ]);

        // Second Form: Feedback Form
        $feedbackForm = Form::create(['name' => 'Feedback Form']);

        $feedbackForm->formFields()->createMany([
            [
                'type' => 'text',
                'label' => 'Name',
                'name' => 'name',
                'placeholder' => 'Your name',
                'options' => [],
                'validation' => [],
                'order' => 1,
            ],
            [
                'type' => 'radio',
                'label' => 'How satisfied are you?',
                'name' => 'satisfaction',
                'placeholder' => '',
                'options' => [
                    ['key' => '1', 'value' => 'Not Satisfied'],
                    ['key' => '2', 'value' => 'Neutral'],
                    ['key' => '3', 'value' => 'Very Satisfied'],
                ],
                'validation' => ['required'],
                'order' => 2,
            ],
            [
                'type' => 'textarea',
                'label' => 'Additional Comments',
                'name' => 'comments',
                'placeholder' => 'Share your thoughts...',
                'options' => [],
                'validation' => [],
                'order' => 3,
            ],
        ]);
    }
}
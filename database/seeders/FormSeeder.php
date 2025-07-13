<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Form;
use App\Models\FormField;

class FormSeeder extends Seeder
{
    public function run()
    {
        // First form
        $form1 = Form::create([
            'name' => 'Contact Form',
            'slug' => 'contact'
        ]);

        $form1Fields = [
            [
                'type' => 'text',
                'label' => 'Name',
                'name' => 'name',
                'options' => null,
                'validation' => ['required'],
                'order' => 1,
            ],
            [
                'type' => 'email',
                'label' => 'Email',
                'name' => 'email',
                'options' => null,
                'validation' => ['required', 'email'],
                'order' => 2,
            ],
            [
                'type' => 'textarea',
                'label' => 'Message',
                'name' => 'message',
                'options' => null,
                'validation' => ['required'],
                'order' => 3,
            ],
        ];

        foreach ($form1Fields as $field) {
            $form1->formFields()->create($field);
        }

        // Second form
        $form2 = Form::create([
            'name' => 'Feedback Form',
            'slug' => 'feedback',
        ]);

        $form2Fields = [
            [
                'type' => 'select',
                'label' => 'Rating',
                'name' => 'rating',
                'options' => ['Excellent', 'Good', 'Fair', 'Poor'],
                'validation' => ['required'],
                'order' => 1,
            ],
            [
                'type' => 'checkbox',
                'label' => 'Subscribe to newsletter',
                'name' => 'subscribe',
                'options' => ['Yes'],
                'validation' => null,
                'order' => 2,
            ],
            [
                'type' => 'text',
                'label' => 'Additional Comments',
                'name' => 'comments',
                'options' => null,
                'validation' => null,
                'order' => 3,
            ],
        ];

        foreach ($form2Fields as $field) {
            $form2->formFields()->create($field);
        }
    }
}

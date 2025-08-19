<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Http\Request;

class FormSubmissionController extends Controller
{
    public function store(Request $request, Form $form)
    {
        // Fetch the field definitions
        $fields = $form->formFields()->orderBy('order')->get();
        // Build validation rules dynamically
        $rules = [];
        foreach ($fields as $field) {
            if (isset($field->validation)) {
                // If validation is empty array, add 'nullable'
                $rules[$field->name] = empty($field->validation) ? ['nullable'] : $field->validation;
            }
        }
        // Validate request
        $validated = $request->validate($rules);

        // Save submission
        $submission = FormSubmission::create([
            'form_id' => $form->id,
            'data' => $validated, // stores as JSON
        ]);

        return redirect()->back()->with('success'. $form->id, 'Form submitted successfully!');
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Form submitted successfully!',
        //     'submission' => $submission
        // ]);
    }
}

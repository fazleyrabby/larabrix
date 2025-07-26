<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FormBuilderRequest;
use App\Models\Form;
use App\Models\FormField;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FormBuilderController extends Controller
{
    public function index(Request $request)
    {
        $forms = Form::where('name', 'like', '%' . $request->q . '%')->latest()->paginate(10);
        return view('admin.forms.index', compact('forms'));
    }

    public function create()
    {
        return view('admin.forms.create');
    }

    public function store(FormBuilderRequest $request)
    {
        $fields = $this->formatFields($request);
        if(Form::where('slug', str()->slug($request->name))->exists()){
            return redirect()->back()->with('error', 'Slug exists!');
        }
        $form = Form::create([
                    'name' => $request->name,
                ]);

        foreach ($fields as $index => $fieldData) {
            $form->formFields()->create($this->formatFieldData($fieldData));
        }

        if($request->input('edit')){
            return redirect()->route('admin.forms.edit', $form->id)->with('success', 'Form created successfully.');
        }
        return redirect()->route('admin.forms.index')->with('success', 'Form created successfully.');
    }

    public function edit(Form $form)
    {
        $form->load('formFields');
        $fields = $form->formFields->map(function($field) {
            return [
                'id' => $field->id,
                'type' => $field->type,
                'label' => $field->label,
                'placeholder' => $field->placeholder,
                'name' => $field->name,
                'options' => $field->options ?? [],
                'validation' => $field->validation ?? [],
            ];
        });
        return view('admin.forms.edit', compact('form','fields'));
    }

    public function update(FormBuilderRequest $request, Form $form)
    {
        $fields = $this->formatFields($request);
        $form->update([
                    'name' => $request->name,
                ]);

        // Update existing and create new fields
        $existingIds = $form->formFields()->pluck('id')->toArray();
        $submittedIds = collect($fields)->pluck('id')->filter()->toArray();

        // Delete removed fields
        $toDelete = array_diff($existingIds, $submittedIds);
        FormField::destroy($toDelete);

        foreach ($fields as $index => $fieldData) {
            $data = $this->formatFieldData($fieldData);
            if (!empty($fieldData['id'])) {
                $form->formFields()->where('id', $fieldData['id'])->update($data);
            } else {
                $form->formFields()->create($data);
            }
        }
        if($request->input('edit')){
            return redirect()->back()->with('success', 'Form updated successfully.');
        }
        return redirect()->route('admin.forms.index')->with('success', 'Form updated successfully.');
    }

    public function destroy(Form $form)
    {
        $form->delete();
        return back()->with('success', 'Form deleted.');
    }

    public function builder(Form $form)
    {
        return view('admin.forms.builder', compact('form'));
    }

    public function saveBuilder(Request $request, Form $form)
    {
        $form->fields = $request->input('fields'); // assumed to be JSON
        $form->save();
        return back()->with('success', 'Form structure saved.');
    }

    private function formatFields($request){
        $fields = $request->input('fields', []);
        $order = 0;
        foreach ($fields as $i => $field) {
            $fields[$i]['order'] = $order;
            if (!empty($field['validation']) && is_string($field['validation'])) {
                $fields[$i]['validation'] = array_map('trim', explode(',', $field['validation']));
            }
            $order++;
            // if (!empty($field['options']) && is_string($field['options'])) {
            //     $fields[$i]['options'] = array_map('trim', explode(',', $field['options']));
            // }
        }
        return $fields;
    }

    private function formatFieldData($fieldData){
        return [
            'type' => $fieldData['type'],
            'label' => $fieldData['label'],
            'name' => $fieldData['name'],
            'placeholder' => $fieldData['placeholder'],
            'options' => json_decode($fieldData['options']) ?? null,
            'validation' => $fieldData['validation'] ?? null,
            'order' => $fieldData['order'],
        ];
    }
}

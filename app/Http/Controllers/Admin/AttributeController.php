<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeRequest;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attributes = Attribute::paginate(10);
        return view('admin.products.attributes.index', compact('attributes'));
    }

    // Show the form for creating a new attribute.
    public function show()
    {
        return view('admin.products.attributes.show');
    }
    // Show the form for creating a new attribute.
    public function create()
    {
        return view('admin.products.attributes.create');
    }

    // Store a newly created attribute in storage.
    public function store(AttributeRequest $request)
    {
        Attribute::create($request->only('title', 'slug'));
        return redirect()->route('admin.products.attributes.index')
                         ->with('success', 'Attribute created successfully.');
    }

    // Show the form for editing the specified attribute.
    public function edit(Attribute $attribute)
    {
        return view('admin.products.attributes.edit', compact('attribute'));
    }

    // Update the specified attribute in storage.
    public function update(AttributeRequest $request, Attribute $attribute)
    {
        $attribute->update($request->validated());
        return redirect()->route('admin.products.attributes.index')
                         ->with('success', 'Attribute updated successfully.');
    }

    // Remove the specified attribute from storage.
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();
        return redirect()->route('admin.products.attributes.index')
                         ->with('success', 'Attribute deleted successfully.');
    }
}

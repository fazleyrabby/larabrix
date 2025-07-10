<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Term;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    public function index()
    {
        $tags = Term::where('type', 'tag')->latest()->paginate(10);
        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'value' => [
                'required',
                'string',
                'max:255',
                Rule::unique('terms')->where(fn ($query) => $query->where('type', 'tag')),
            ],
        ]);
        $term = Term::create([
            'type' => 'tag',
            'value' => $validated['value'],
        ]);
        return redirect()->route('admin.tags.index')->with('success', 'Tag created.');
    }

    public function edit(Term $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Term $tag)
    {
        $validated = $request->validate([
            'value' => [
                'required',
                'string',
                'max:255',
                Rule::unique('terms')
                    ->where(fn ($query) => $query->where('type', 'tag'))
                    ->ignore($tag->id),
            ],
        ]);
        $tag->update($validated);
        return redirect()->route('admin.tags.index')->with('success', 'Tag updated.');
    }

    public function destroy(Term $tag)
    {
        $tag->delete();
        return redirect()->route('admin.tags.index')->with('success', 'Tag deleted.');
    }
}

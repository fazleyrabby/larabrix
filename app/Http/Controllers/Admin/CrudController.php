<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Crud;
use App\Http\Requests\CrudRequest;
use App\Services\CrudService;
use Illuminate\Http\Request;
use App\Traits\UploadPhotos;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CrudController extends Controller
{
    use UploadPhotos;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, CrudService $crudService)
    {
        $cruds = $crudService->getPaginatedItems($request->all());
        return view('admin.cruds.index', compact('cruds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cruds.create');
    }

    public function store(CrudRequest $request)
    {
        // $this->authorize('create', Crud::class);
        $data = $request->validated();
        if ($request->hasFile('default_file_input')) {
            $data['default_file_input'] = $this->uploadPhoto($request->file('default_file_input'));
        }
        if ($request->filled('filepond_input')) {
            $file = $this->processFilepondTempFile($request->input('filepond_input'));
            $data['filepond_input'] = $this->uploadPhoto($file);
            // To delete temp file
            $this->deleteImage($request->input('filepond_input'));
        }
        Crud::create($data);
        if ($request->input('action') === 'save_and_create') {
            return redirect()->route('admin.cruds.create')->with('success', 'Saved. You can add another one.');
        }
        return redirect()->route('admin.cruds.index')->with(['success' => 'Successfully created!']);
    }

    public function show(Crud $crud)
    {
        $crud->custom_select = $crud->custom_select ? [
            1 => 'Chuck Tesla',
            2 => 'Elon Musk',
            3 => 'Pawel Kuna',
            4 => 'Nikola Tesla',
        ][$crud->custom_select] : "";
        return view('admin.cruds.show', compact('crud'));
    }

    public function edit(Crud $crud)
    {
        // $this->authorize('edit', Crud::class);
        return view('admin.cruds.edit', compact('crud'));
    }

    public function update(CrudRequest $request, $id)
    {
        $crud = Crud::findOrFail($id);
        $data = $request->validated();

        $data['media_input'] = $request->input('media_input');
        
        if ($request->hasFile('default_file_input')) {
            $data['default_file_input'] = $this->uploadPhoto(
                $request->file('default_file_input'),
                $crud->default_file_input
            );
        }

        $filepondInput = $request->input('filepond_input');

        if ($request->filled('filepond_input') && Str::startsWith($filepondInput, 'tmp/')) {
            $tempFile = $this->processFilepondTempFile($filepondInput);
            $data['filepond_input'] = $this->uploadPhoto($tempFile, $crud->filepond_input ?? '');
            $this->deleteImage($filepondInput); // Clean up
        } else {
            $data['filepond_input'] = null;
        }
        $crud->update($data);

        return redirect()
            ->route('admin.cruds.index')
            ->with('success', 'Successfully updated!');
    }

    public function destroy($id)
    {
        // $this->authorize('delete', Crud::class);
        $crud = Crud::findOrFail($id);
        $crud->delete();
        return redirect()->route('admin.cruds.index')->with(['success' => 'Successfully deleted!']);
    }

    public function upload(Request $request)
    {
        if ($request->file('filepond_input')) {
            $path = $request->file('filepond_input')->store('tmp', 'public');
            return response($path, 200)->header('Content-Type', 'text/plain');
        }
        return response('No file', 400);
    }
    public function revert(Request $request)
    {
        Storage::disk('public')->delete($request->getContent());
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Crud;
use App\Http\Requests\CrudRequest;
use App\Services\CrudService;
use Illuminate\Http\Request;
use App\Traits\UploadPhotos;

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
        // Crud::create($request->validated());
        $data = $request->validated(); // Get validated data
        if ($request->hasFile('default_file_input')) {
            $data['default_file_input'] = $this->uploadPhoto($request->file('default_file_input'));
        }
        Crud::create($data);
        return redirect()->route('admin.cruds.create')->with(['success' => 'Successfully created!']);
    }

    public function show(Crud $crud)
    {
        return view('admin.cruds.show', compact('crud'));
    }

    public function edit(Crud $crud)
    {
        // $this->authorize('edit', Crud::class);
        return view('admin.cruds.edit', compact('crud'));
    }

    public function update(CrudRequest $request, $id)
    {
        // $this->authorize('update', Supplier::class);
        $crud = Crud::findOrFail($id);
        $data = $request->validated();
        if ($request->hasFile('default_file_input')) {
            $data['default_file_input'] = $this->uploadPhoto($request->file('default_file_input'), $crud->default_file_input);
        }
        $crud->update($data);
        return redirect()->route('admin.cruds.index')->with(['success' => 'Successfully updated!']);
    }

    public function destroy($id)
    {
        // $this->authorize('delete', Crud::class);
        $crud = Crud::findOrFail($id);
        $crud->delete();
        return redirect()->route('admin.cruds.index')->with(['success' => 'Successfully deleted!']);
    }
}

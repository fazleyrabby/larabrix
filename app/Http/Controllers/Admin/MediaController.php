<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\MediaFolder;
use App\Traits\UploadPhotos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MediaController extends Controller
{
    use UploadPhotos;
    public function index(Request $request)
    {
        $search_query = $request->q;
        $status = $request->status ?? 1;
        $limit = $request->limit ?? 10;
        $folderId = $request->parent_id;
        $folders = MediaFolder::toBase()->where('parent_id', $folderId)->orderBy('created_at', 'DESC')->get();
        $media = Media::toBase()->select('id', 'url', 'created_at', 'status', 'folder_id')
            ->where('folder_id', $folderId)
            ->where('url', 'like', '%' . $search_query . '%')
            ->when(!request()->has('q'), function ($query) use ($status) {
                $query->where('status', $status);
            })->orderBy('created_at', 'desc')->paginate($limit);

        
        if ($request->ajax()) {
            $html = view('admin.components.media.items', compact('media', 'folders'))->render();
            if ($request->get('type') == 'modal') {
                return response()->json([
                    'html' => $html,
                    'meta' => [
                        'current_page' => $media->currentPage(),
                        'last_page' => $media->lastPage(),
                    ],
                ]);
            }
            return $html;
        }
        $media->appends(request()->query());
        return view('admin.media.index', compact('media', 'folders'));
    }

    public function store(Request $request)
    {
        if (!$request->hasFile('images')) {
            return response()->json([
                'success' => 'error',
                'message' => "No image selected!",
            ]);
        }
        $folder = MediaFolder::find($request->parent_id);
        $folderPath = $folder ? $folder->path : 'media';
        $data = [];
        try {
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $validator = Validator::make(
                        ['image' => $file],
                        ['image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'] // max 2MB
                    );
                    if ($validator->fails()) {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'One or more files are invalid: ' . $validator->errors()->first(),
                            'refresh' => false,
                        ], 422);
                    }

                    $imagePath = $this->uploadPhoto($file, '', $folderPath);
                    $data[] = [
                        'url' => $imagePath,
                        'folder_id' => $folder?->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
            Media::insert($data);
            $success = 'success';
            $message = 'Media Successfully Updated!';
            $refresh = true;
        } catch (\Throwable $th) {
            Log::error('Error occurred while media File upload :' . $th);
            $success = 'error';
            $message = 'Upload Error';
            $refresh = false;
        }

        $response = [
            'success' => $success,
            'message' => $message,
            'refresh' => $refresh
        ];

        return response()->json($response);
    }

    public function downloadImage(Request $request)
    {
        return Storage::disk('public')->download($request->url);
    }

    public function delete(Request $request)
    {
        $ids = $request->ids;
        try {
            $media = Media::whereIn('id', $ids);
            if ($media->exists()) {
                foreach ($media->get() as $image) {
                    $this->deleteImage($image->url);
                }
            }
            $media->delete();
            $status = "success";
            $message = "Media files successfully deleted";
        } catch (\Illuminate\Database\QueryException $ex) {
            $status = "error";
            $message = $ex->getMessage();
        }
        return redirect()->route('admin.media.index')->with($status, $message);
    }

    public function storeFolder(Request $request)
    {
        $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('media_folders')->where(function ($query) use ($request) {
                        return $query->where('parent_id', $request->input('parent_id'));
                    }),
                ],
                'parent_id' => 'nullable|exists:media_folders,id',
            ],
            [
                'name.required' => 'The folder name is required.',
                'name.unique' => 'A folder with this name already exists in the selected directory.',
                'parent_id.exists' => 'The selected parent folder does not exist.',
            ]
        );
        try {
            $parentPath = '';
            if ($request->parent_id) {
                $parent = MediaFolder::find($request->parent_id);
                $parentPath = $parent->path . '/';
            }

            $parentPath = ltrim($parentPath, '/'); // remove leading slash
            $parentPath = preg_replace('/^media\//', '', $parentPath);// remove existing "media/" prefix if exists

            $fullPath = 'media/' . $parentPath . $request->name;
 
            // Create the folder physically
            Storage::disk('public')->makeDirectory($fullPath);

            // Save in DB
            $folder = MediaFolder::create([
                'name' => $request->name,
                'path' => $fullPath,
                'parent_id' => $request->parent_id,
            ]);
            $success = 'success';
            $message = 'Media Successfully Updated!';
        } catch (\Throwable $th) {
            Log::error('Error occurred while media File upload :' . $th);
            $success = 'error';
            $message = 'Upload Error';
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];
        
        if ($request->ajax() || $request->expectsJson()) {
            return response()->json($response);
        }
        
        return redirect()->back()->with($success, $message);
    }

    // public function move(Request $request)
    // {
    //     $request->validate([
    //         'id' => 'required|exists:folders,id',
    //         'parent_id' => 'nullable|exists:folders,id|not_in:' . $request->id, // prevent moving to self
    //     ]);

    //     $folder = MediaFolder::findOrFail($request->id);
    //     $folder->parent_id = $request->parent_id ?: null;
    //     $folder->save();

    //     return response()->json(['success' => 'success', 'message' => 'Folder moved successfully']);
    // }

    public function moveFolder(Request $request)
    {
        if ($request->isFile) {
            return $this->moveFile($request);
        }
        $request->validate([
            'id' => 'required|exists:media_folders,id',
            'parent_id' => 'nullable|exists:media_folders,id|not_in:' . $request->id,
        ]);

        $folder = MediaFolder::findOrFail($request->id);
        $oldPath = $this->resolveFolderPath($folder);
        $newParent = $request->parent_id ? MediaFolder::findOrFail($request->parent_id) : null;

        // Optional: prevent circular move
        if ($this->isDescendant($folder, $request->parent_id)) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot move folder into its own descendant.'
            ], 422);
        }

        $newPath = $this->resolveFolderPath($newParent) . '/' . $folder->name;

        if (File::exists($newPath)) {
            return response()->json([
                'success' => false,
                'message' => 'A folder with the same name already exists in the target location.'
            ], 422);
        }

        Storage::disk('public')->makeDirectory(dirname($newPath));
        Storage::disk('public')->move($oldPath, $newPath);

        $folder->update([
            'parent_id' => $request->parent_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Folder moved successfully.',
        ]);
    }

    protected function moveFile(Request $request)
    {
        $validated = $request->validate([
            'parent_id' => ['nullable', 'exists:media_folders,id'],
        ]);
        $validated['parent_id'] = $validated['parent_id'] ?: null;

        $file = Media::findOrFail($request->id);
        $oldPath = $file->url;

        // Generate new relative path
        $newParentFolder = $request->parent_id ? MediaFolder::findOrFail($request->parent_id) : null;
        $newDir = $this->resolveFolderPath($newParentFolder);
        $newPath = $newDir . '/' . basename($oldPath);

        if (Storage::disk('public')->exists($newPath)) {
            return response()->json([
                'success' => false,
                'message' => 'A file with the same name already exists in the target folder.',
            ], 422);
        }

        // Ensure the destination directory exists
        Storage::disk('public')->makeDirectory($newDir);

        // Move the file
        Storage::disk('public')->move($oldPath, $newPath);

        // Update DB record
        $file->update([
            'folder_id' => $request->parent_id,
            'url' => $newPath,
        ]);

        return response()->json([
            'success' => 'success',
            'message' => 'File moved successfully.',
        ]);
    }
    protected function resolveFolderPath(?MediaFolder $folder)
    {
        if (!$folder) {
            return 'media';
        }

        $segments = [];
        while ($folder) {
            array_unshift($segments, $folder->name);
            $folder = $folder->parent;
        }

        return 'media/' . implode('/', $segments);
    }
    protected function isDescendant(MediaFolder $folder, $parentId): bool
    {
        while ($parentId) {
            if ($folder->id == $parentId) {
                return true;
            }
            $parent = MediaFolder::find($parentId);
            $parentId = $parent?->parent_id;
        }

        return false;
    }

    public function deleteFolder($id)
    {
        $folder = MediaFolder::findOrFail($id);

        // Prevent deletion if it has subfolders or files
        if ($folder->children()->exists() || $folder->files()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Folder is not empty. Delete its contents first.',
            ], 422);
        }

        $folderPath = $this->resolveFolderPath($folder);

        // Delete folder from filesystem
        if (Storage::disk('public')->exists($folderPath)) {
            Storage::disk('public')->deleteDirectory($folderPath);
        }

        // Delete folder from DB
        $folder->delete();

        return response()->json([
            'success' => 'success',
            'message' => 'Folder deleted successfully.',
        ]);
    }
}

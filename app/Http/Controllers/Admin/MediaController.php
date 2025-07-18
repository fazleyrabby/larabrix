<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\MediaFolder;
use App\Traits\UploadPhotos;
use Illuminate\Http\Request;
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
        $folders = MediaFolder::toBase()->where('parent_id', $folderId)->orderBy('created_at','DESC')->get();
        $media = Media::toBase()->select('id', 'url', 'created_at', 'status')
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
        try {
            $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('media_folders')->where(function ($query) use ($request) {
                        return $query->where('parent_id', $request->input('parent_id'));
                    }),
                ],
                'parent_id' => 'nullable|exists:media_folders,id',
            ]);

            $parentPath = '';
            if ($request->parent_id) {
                $parent = MediaFolder::find($request->parent_id);
                $parentPath = $parent->path . '/';
            }

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

        if($request->ajax()){
            return response()->json($response);
        }
        return redirect()->back()->with($success,$message);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Traits\UploadPhotos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    use UploadPhotos;
    public function index(Request $request)
    {
        $search_query = $request->q;
        $status = $request->status ?? 1;
        $media = Media::select('id', 'url', 'created_at', 'status')
            ->where('url', 'like', '%' . $search_query . '%')
            ->when(!request()->has('q'), function ($query) use ($status) {
                $query->where('status', $status);
            })->orderBy('created_at', 'desc');

        if ($request->ajax()) {
            $media = $media->paginate(12);
            return view('admin.components.media.items', compact('media'));
            // return view('admin.media.ajax', compact('media'));
        }
        $media = $media->paginate(15);
        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request)
    {
        try {
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $image = $this->uploadPhoto($file, '', 'media/');
                    $data[] =  [
                        'url' => $image,
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
            Log::error('Error occurred while media File upload :'. $th);
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

    public function downloadImage(Request $request){
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


    public function browse(Request $request)
    {
        $folder = trim($request->get('folder', ''), '/');
        $path = $folder ? "media/{$folder}" : "media";

        return response()->json([
            'current_folder' => $folder,
            'folders' => Storage::disk('public')->directories($path),
            'files' => Storage::disk('public')->files($path),
            'parent_folder' => $this->getParentFolder($folder),
        ]);
    }

    private function getParentFolder($folder)
    {
        if (!$folder) return null;
        $parts = explode('/', $folder);
        array_pop($parts);
        return implode('/', $parts);
    }

    public function createFolder(Request $request)
    {
        $request->validate(['folder' => 'required|string']);

        $path = 'media/' . trim($request->input('folder'), '/');

        if (!Storage::disk('public')->exists($path)) {
            Storage::disk('public')->makeDirectory($path);
        }

        return response()->json(['status' => 'ok']);
    }
    public function folderTree()
    {
        return response()->json([
            'tree' => $this->getFolderTree('media'),
        ]);
    }

    private function getFolderTree($path)
    {
        $directories = Storage::disk('public')->directories($path);
        $tree = [];

        foreach ($directories as $dir) {
            $tree[] = [
                'name' => basename($dir),
                'full_path' => str_replace('media/', '', $dir),
                'children' => $this->getFolderTree($dir),
            ];
        }

        return $tree;
    }
}

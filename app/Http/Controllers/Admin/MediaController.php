<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Traits\UploadPhotos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MediaController extends Controller
{
    use UploadPhotos;
    public function index(Request $request)
    {
        $search_query = $request->q;
        $status = $request->status ?? 1;
        $media = Media::toBase()->select('id', 'url', 'created_at', 'status')
            ->where('url', 'like', '%' . $search_query . '%')
            ->when(!request()->has('q'), function ($query) use ($status) {
                $query->where('status', $status);
            })->orderBy('created_at', 'desc')->paginate(6);

        if ($request->ajax()) {
            $html = view('admin.components.media.items', compact('media'))->render();
            if($request->get('type') == 'modal'){
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
        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request)
    {
        if(!$request->hasFile('images')){
            return response()->json([
                'success' => 'error',
                'message' => "No image selected!",
            ]);
        }
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

                    $imagePath = $this->uploadPhoto($file, '', 'media/');
                    $data[] = [
                        'url' => $imagePath,
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

    public function tree(){
        $directories = Storage::disk('public')->directories('media/');
        dd($directories);
    }
}

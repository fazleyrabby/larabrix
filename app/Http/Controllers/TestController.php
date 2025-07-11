<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function index(){

        $response = app()->handle(
            Request::create('/admin/media/browse?folder=media', 'GET')
        );
        $data = $response->getContent();
        return $data;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageBuilderController extends Controller
{
    public function index(Request $request, $id){
        return view('admin.pages.builder', [
            'hideSidebar' => true,
            'hideNavbar' => true,
            'hideFooter' => true,
            'page' => Page::find($id)
        ]);
    }
}

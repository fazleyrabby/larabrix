<?php

namespace App\Http\Controllers\Admin;

use App\Builders\PageBlocks;
use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\Page;
use Illuminate\Http\Request;

class PageBuilderController extends Controller
{
    public function index(Request $request, $id){
        $page = Page::find($id);
        $pageBlocks = PageBlocks::all();
        $forms = Form::toBase()->pluck('name', 'id');
        return view('admin.pages.builder', [
            'hideSidebar' => true,
            'hideNavbar' => true,
            'hideFooter' => true,
            'page' => $page,
            'pageBlocks' => $pageBlocks,
            'forms' => $forms
        ]);
    }

    public function store(Request $request, $id){
        $page = Page::find($id);
        $page->builder = json_encode($request->builder);
        $page->save();
        return response()->json([
            'success' => 'success',
            'message' => 'Builder updated!'
        ]);
    }
}

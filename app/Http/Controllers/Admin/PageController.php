<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageStoreRequest;
use App\Http\Requests\PageUpdateRequest;
use App\Services\PageService;
use League\CommonMark\CommonMarkConverter;
use Spatie\LaravelMarkdown\Markdown;

class PageController extends Controller
{
    protected PageService $service;
    public function __construct(){
        $this->service = new PageService;
    }
    public function index(Request $request)
    {
        $pages = $this->service->getPaginatedItems($request->all());
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(PageStoreRequest $request)
    {
        $data = $request->validated();

        $page = Page::create($data);

        if($request->input('save')){
            return redirect()->route('admin.pages.edit', $page->id)->with('success', 'Page created successfully.');
        }
        return redirect()->route('admin.pages.index')
            ->with('success', 'Page created successfully.');
    }

    public function show(Page $page)
    {
        $markdown = new CommonMarkConverter();
        $content = $markdown->convert($page->content)->getContent();
        return view('admin.pages.show', compact('page','content'));
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(PageUpdateRequest $request, Page $page)
    {
        $data = $request->validated();
        $page->update($data);
        
        if($request->input('save')){
            return redirect()->back()->with('success', 'Page updated successfully.');
        }
        return redirect()->route('admin.pages.index')
            ->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page deleted successfully.');
    }
    
}

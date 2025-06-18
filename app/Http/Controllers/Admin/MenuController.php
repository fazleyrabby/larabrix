<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Models\Menu;
use App\Services\MenuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    protected MenuService $service;
    public function __construct(){
        $this->service = new MenuService;
    }
    public function index(Request $request)
    {
        $menus = $this->service->getPaginatedItems($request->all());
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        $menus = Menu::toBase()->pluck('title', 'id');
        return view('admin.menus.create', compact('menus'));
    }

    public function store(MenuRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = $request->has('slug') ? str_replace('-', '', $request->slug) : str()->slug($request->title);
        $data['parent_id'] = $request->has('parent_id') ?? 0;
        Menu::create($data);
        return redirect()->route('admin.menus.create')->with(['success' => 'Successfully created!']);
    }

    public function show(Menu $menu)
    {
        return view('admin.menus.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        $menus = Menu::toBase()->whereNot('id', $menu->id)->pluck('title', 'id');
        return view('admin.menus.edit', compact('menus','menu'));
    }

    public function update($id, MenuRequest $request)
    {
        $data = $request->validated();
        $menu = Menu::findOrFail($id);
        $data['slug'] = $request->has('slug') ? str_replace('-', '', $request->slug) : str()->slug($request->title);
        $data['parent_id'] = $request->parent_id ?? 0;
        $menu->update($data);
        return redirect()->route('admin.menus.index')->with(['success' => 'Successfully updated!']);
    }

    public function sort()
    {
        $menuWithoutChildren = Menu::toBase()->select('id','parent_id','position')->get();
        $menus = Menu::with('childrenRecursive')->where([
            ['status', 1],
            ['parent_id', 0],
        ])->orderBy('position')->get();
        return view('admin.menus.sort', compact('menus','menuWithoutChildren'));
    }

    public function saveSortedMenu(Request $request)
    {
        $data = $request->input('menu_structure');
        $menuItems = json_decode($data, true);
        $query = $this->service->generalBulkUpdateQuery($menuItems);
        DB::statement($query);
        return redirect()->back()->with('success', 'Menu order updated successfully.');
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MenuType;
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
        if($request->get('type')){
            $menus = $this->service->getPaginatedItems($request->all());
            return view('admin.menus.index', compact('menus'));
        }
        $menuTypes = MenuType::cases();
        return view('admin.menus.types', compact('menuTypes'));
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
        $data['parent_id'] = $request->input('parent_id', 0);
        Menu::create($data);
        return redirect()->route('admin.menus.create', ['type' => $request->input('type')])->with(['success' => 'Successfully created!']);
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

    public function update(Menu $menu, MenuRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = $request->has('slug') ? str_replace('-', '', $request->slug) : str()->slug($request->title);
        $data['parent_id'] = $request->input('parent_id', 0);
        $menu->update($data);
        return redirect()->route('admin.menus.index',['type' => $request->input('type')])->with(['success' => 'Successfully updated!']);
    }

    public function sort(Request $request)
    {
        $menuWithoutChildren = Menu::toBase()->where('type', $request->get('type'))->select('id','parent_id','position')->get();
        $menus = Menu::with('childrenRecursive')->where([
            ['status', 1],
            ['type', $request->get('type')],
            ['parent_id', 0],
        ])->orderBy('position')->get();
        return view('admin.menus.sort', compact('menus','menuWithoutChildren'));
    }

    public function saveSortedMenu(Request $request)
    {
        $data = $request->input('menu_structure');
        $menuItems = json_decode($data, true);
        $query = $this->service->generateBulkUpdateQuery($menuItems);
        DB::statement($query);
        return redirect()->back()->with('success', 'Menu order updated successfully.');
    }

}

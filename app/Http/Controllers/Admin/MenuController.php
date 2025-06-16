<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Models\Menu;
use App\Services\MenuService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request, MenuService $menuService)
    {
        $menus = $menuService->getPaginatedItems($request->all());
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menus.create');
    }

    public function store(MenuRequest $request)
    {
        $data = $request->validated();
        Menu::create($data);
        return redirect()->route('admin.menus.create')->with(['success' => 'Successfully created!']);
    }

    public function sort()
    {
        $menus = Menu::with('childrenRecursive')->where([
            ['status', 1],
            ['parent_id', 0],
        ])->get();
        return view('admin.menus.sort', compact('menus'));
    }

}

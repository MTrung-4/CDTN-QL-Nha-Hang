<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateFormRequest;
use App\Http\Services\Menu\MenuService;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
        $this->middleware('checkRole:admin, staff');
    }

    public function create()
    {
        $this->authorize('create', Menu::class);
        return view('admin.menu.add', [
            'title' => 'Thêm Danh Mục Mới',
            'menus' => $this->menuService->getParent()
        ]);
    }

    public function store(CreateFormRequest $request)
    {

        $this->authorize('create', Menu::class);
        $this->menuService->create($request);

        return redirect()->back();
    }

    public function index()
    {
        $this->authorize('view', Menu::class);
        return view('admin.menu.list', [
            'title' => 'Danh Sách Danh Mục Mới Nhất',
            'menus' => $this->menuService->getAll()
        ]);
    }

    public function edit(Menu $menu)
    {
        $this->authorize('edit', Menu::class);
        return view('admin.menu.edit', [
            'title' => 'Chỉnh Sửa Danh Mục: ' . $menu->name,
            'menu' => $menu,
            'menus' => $this->menuService->getParent()
        ]);
    }

    public function update(Menu $menu, CreateFormRequest $request)
    {

        $this->authorize('update', Menu::class);
        $this->menuService->update($request, $menu);

        return redirect('/admin/menus/list');
    }

    public function destroy(Request $request): JsonResponse
    {

        $this->authorize('delete', Menu::class);
        $result = $this->menuService->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công danh mục'
            ]);
        }

        return response()->json([
            'error' => true
        ]);
    }
}

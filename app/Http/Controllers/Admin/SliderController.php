<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Slider\SliderService;
use App\Models\Slider;

class SliderController extends Controller
{
    protected $slider;


    public function __construct(SliderService $slider)
    {
        $this->slider = $slider;
        $this->middleware('checkRole:admin, staff');
    
    }

    public function create()
    {
        $this->authorize('create', Slider::class);
        return view('admin.slider.add', [
            'title' => 'Thêm Slider Mới'
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Slider::class);
       
        $this->validate($request, [
            'name' => 'required|string|max:255|unique:sliders,name',
            'thumb' => 'required',
        ], [
            'name.required' => 'Tên slider không được để trống',
            'name.unique' => 'Tên slider đã tồn tại',
            'thumb.required' => 'Ảnh không được để trống',
        ]);
        $this->slider->insert($request);

        return redirect()->back();
    }

    public function index()
    {
        $this->authorize('view', Slider::class);
        return view('admin.slider.list', [
            'title' => 'Danh Sách Slider Mới Nhất',
            'sliders' => $this->slider->get()
        ]);
    }

    public function edit(Slider $slider)
    {
        $this->authorize('edit', Slider::class);
        return view('admin.slider.edit', [
            'title' => 'Chỉnh Sửa Slider',
            'slider' => $slider
        ]);
    }

    public function update(Request $request, Slider $slider)
    {
        $this->authorize('update', Slider::class);
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'thumb' => 'required',
        ], [
            'name.required' => 'Tên slider không được để trống',
            'thumb.required' => 'Ảnh không được để trống',
        ]);

        $result = $this->slider->update($request, $slider);
        if ($result) {
            return redirect('/admin/sliders/list');
        }
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $this->authorize('delete', Slider::class);
        $result = $this->slider->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công Slider'
            ]);
        }

        return response()->json(['error' => true]);
    }
}

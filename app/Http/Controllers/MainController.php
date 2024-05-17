<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Slider\SliderService;
use App\Http\Services\Menu\MenuService;
use App\Http\Services\Product\ProductService;
use App\Jobs\SendThankYouEmail;
use App\Models\Feedback;
use Illuminate\Support\Facades\Log;


class MainController extends Controller
{
    protected $slider;
    protected $menu;
    protected $product;

    public function __construct(
        SliderService $slider,
        MenuService $menu,
        ProductService $product
    ) {
        $this->slider = $slider;
        $this->menu = $menu;
        $this->product = $product;
    }

    public function index(Request $request)
    {
        $filteredProducts = $this->product->filter($request);

        return view('home', [
            'title' => 'Nhà Hàng Yến',
            'sliders' => $this->slider->show(),
            'menus' => $this->menu->show(),
            'products' => $this->product->get(),
            'filteredProducts' => $filteredProducts,
        ]);
    }

    public function loadProduct(Request $request)
    {
        $page = $request->input('page', 0);
        $result = $this->product->get($page);
        if (count($result) != 0) {
            $html = view('products.list', ['products' => $result])->render();

            return response()->json(['html' => $html]);
        }

        return response()->json(['html' => '']);
    }
}

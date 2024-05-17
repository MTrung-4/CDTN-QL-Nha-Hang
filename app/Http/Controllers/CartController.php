<?php

namespace App\Http\Controllers;

use App\Http\Services\CartService;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        $result = $this->cartService->create($request);
        if ($result === false) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi thêm món ăn.');
        }

        return redirect()->back()->with('success', 'Thêm thành công vào giỏ hàng.');
    }

    public function show()
    {
        $products = $this->cartService->getProduct();

        return view('carts.list', [
            'title' => 'Giỏ Hàng',
            'products' => $products,
            'carts' => Session::get('carts', []),
        ]);
    }

    public function update(Request $request)
    {
        $result = $this->cartService->update($request);

        if ($result) {
            Session::flash('success', 'Cập nhật giỏ hàng thành công.');
        } else {
            Session::flash('error', 'Có lỗi xảy ra khi cập nhật giỏ hàng.');
        }

        return redirect('/carts');
    }

    public function remove($id = 0)
    {
        $result = $this->cartService->remove($id);

        if ($result) {
            Session::flash('success', 'Xóa sản phẩm khỏi giỏ hàng thành công.');
        } else {
            Session::flash('error', 'Có lỗi xảy ra khi xóa sản phẩm khỏi giỏ hàng.');
        }

        return redirect('/carts');
    }

    public function addCart(Request $request)
    {
        $this->cartService->addCart($request);

        Session::forget('carts');

        $customer_id = Session::get('customer_id');

        return redirect()->route('order.summary', ['id' => $customer_id]);
    }

    public function summary($customerId)
    {
        if (!$customerId) {
            abort(404, 'Không tìm thấy đơn hàng');
        }

        $customer = Customer::find($customerId);

        if (!$customer) {
            abort(404, 'Khách hàng không tồn tại');
        }

        $cart = Cart::where('customer_id', $customerId)->first();

        if (!$cart) {
            abort(404, 'Đơn hàng không tồn tại');
        }

        $products = $customer->carts()->with('product')->get();

        return view('carts.summary', [
            'title' => 'Thanh Toán',
            'customer' => $customer,
            'cart' => $cart,
            'products' => $products,
        ]);
    }
}

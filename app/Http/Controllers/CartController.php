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
            return redirect()->back();
        }

        return redirect('/carts');
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
        $this->cartService->update($request);

        return redirect('/carts');
    }

    public function remove($id = 0)
    {
        $this->cartService->remove($id);

        return redirect('/carts');
    }

    public function addCart(Request $request)
    {
        $this->cartService->addCart($request);

        // Lấy giá trị của customer_id từ session
        $customer_id = Session::get('customer_id');

        // Chuyển hướng đến route 'order.summary' với tham số 'id' là 'customer_id'
        return redirect()->route('order.summary', ['id' => $customer_id]);
    }

    public function summary($customerId)
    {
        // Kiểm tra xem customerId có tồn tại không
        if (!$customerId) {
            abort(404, 'Không tìm thấy đơn hàng');
        }

        // Lấy thông tin khách hàng từ $customerId
        $customer = Customer::find($customerId);

        // Kiểm tra xem khách hàng có tồn tại không
        if (!$customer) {
            abort(404, 'Khách hàng không tồn tại');
        }

        // Lấy thông tin đơn hàng từ customerId
        $cart = Cart::where('customer_id', $customerId)->first();

        // Kiểm tra xem đơn hàng có tồn tại không
        if (!$cart) {
            abort(404, 'Đơn hàng không tồn tại');
        }

        // Lấy các sản phẩm được liên kết với đơn hàng
        $products = $customer->carts()->with('product')->get();

        // Truyền thông tin khách hàng, đơn hàng và các sản phẩm vào view
        return view('carts.summary', [
            'title' => 'Thanh Toán',
            'customer' => $customer,
            'cart' => $cart,
            'products' => $products,
        ]);
    }
}

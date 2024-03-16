<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Services\CartService;
use App\Models\Cart;

class CartController extends Controller
{
    protected $cart;
    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    public function index(Customer $customer)
    {
        $customers = $this->cart->getCustomer();

        // Tính tổng giá tiền của từng đơn hàng
        foreach ($customers as $customer) {
            $customer->totalPrice = $this->cart->getTotalPriceForCustomer($customer);
        }

        return view('admin.carts.customer', [
            'title' => 'Danh Sách Đơn Đặt Hàng',
            'customers' => $customers,
        ]);
    }

    public function show(Customer $customer)
    {
        $carts = $this->cart->getProductForCart($customer);

        return view('admin.carts.detail', [
            'title' => 'Chi Tiết Đơn Hàng: ' . $customer->name,
            'customer' => $customer,
            'carts' => $carts
        ]);
    }
}

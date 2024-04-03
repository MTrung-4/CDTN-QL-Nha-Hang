<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Services\CartService;
use App\Models\Cart;
use App\Models\Table;

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
        $cartId = Cart::all();

        // Tính tổng giá tiền của từng đơn hàng
        foreach ($customers as $customer) {
            $customer->totalPrice = $this->cart->getTotalPriceForCustomer($customer);
        }

        return view('admin.carts.customer', [
            'title' => 'Danh Sách Đơn Đặt Hàng',
            'customers' => $customers,
            'cartId' => $cartId,
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

    public function selectTableForCustomer(Request $request)
    {
        $customerId = $request->input('customer_id');
        $tableId = $request->input('table_id');

        // Lấy cart của customer
        $cart = Cart::where('customer_id', $customerId)->first();

        // Kiểm tra table có tồn tại hay không
        $table = Table::find($tableId);

        if (!$table) {
            return response()->json(['error' => 'Không có bàn!'], 404);
        }

        // Lấy thông tin về số lượng trong giỏ hàng và sức chứa của bàn từ cơ sở dữ liệu
        $cartQty = Cart::where('customer_id', $customerId)->count();
        $tableCapacity = Table::find($tableId)->capacity;

        if ($cartQty >= $tableCapacity) {
            return response()->json(['error' => 'Không thể chọn bàn. Số lượng người lớn hơn sức chứa của bàn!']);
        }

        // Kiểm tra nếu bàn đang trống
        if ($table->active == 1) {
            // Cập nhật trạng thái của bàn trong cơ sở dữ liệu
            $table->active = 0; // Bàn không còn trống
            $table->save();
        }


        // Lưu table_id vào cart
        $cart->table_id = $tableId;
        $cart->save();

        return response()->json(['message' => 'Lấy bàn thành công.']);
    }
}

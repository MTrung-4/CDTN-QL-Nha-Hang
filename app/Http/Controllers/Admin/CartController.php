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

    public function index()
    {
        $customers = $this->cart->getCustomer();
        $carts = Cart::all();

        // Tính tổng giá tiền của từng đơn hàng
        foreach ($customers as $customer) {
            $customer->totalPrice = $this->cart->getTotalPriceForCustomer($customer);
        }

        return view('admin.carts.customer', [
            'title' => 'Danh Sách Đơn Đang Xử Lý',
            'customers' => $customers,
            'carts' => $carts,
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

    public function addCart(Request $request)
    {
        $result = $this->cart->addCart($request);

        if ($result) {
            return redirect()->back()->with('success', 'Đặt hàng thành công!');
        } else {
            return redirect()->back()->with('error', 'Đặt hàng thất bại, vui lòng thử lại sau!');
        }
    }

    public function waiting()
    {
        $customers = $this->cart->getCustomerWithNullStatus(); // Thay đổi để chỉ lấy các đơn hàng chưa có giá trị trong status

        return view('admin.carts.waiting', [
            'title' => 'Danh Sách Đơn Chờ Duyệt',
            'customers' => $customers,
        ]);
    }

    public function history()
    {
        $customers = $this->cart->getApproveCard();
        $carts = $this->cart->getApproveCard();

        return view('admin.carts.history', [
            'title' => 'Danh Sách Đơn Đã Hủy',
            'customers' => $customers,
            'carts' => $carts,
        ]);
    }

    public function cancel()
    {
        $customers = $this->cart->getRejectCard();
        $carts = $this->cart->getRejectCard();

        return view('admin.carts.cancel', [
            'title' => 'Danh Sách Đơn Đã Hủy',
            'customers' => $customers,
            'carts' => $carts,
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
            $table->active = 0; // Bàn không còn trống
            $table->save();
        }

        // Lưu table_id vào cart
        if ($cart) {
            $cart->table_id = $tableId;
            $cart->save();
        }

        return response()->json(['message' => 'Lấy bàn thành công.']);
    }

    public function savePaymentOption(Request $request)
    {
        $response = $this->cart->savePaymentOption($request);
        return response()->json($response);
    }


    public function updateStatus(Request $request)
    {
        $customerId = $request->input('customer_id');
        $status = $request->input('status');
        $cancelReason = $request->input('cancel_reason'); // Lấy dữ liệu lý do hủy đơn

        $result = $this->cart->updateStatus($customerId, $status, $cancelReason); // Pass lý do hủy đơn vào phương thức updateStatus

        if ($result) {
            return response()->json(['success' => true, 'message' => 'Trạng thái của đơn hàng đã được cập nhật thành công']);
        }

        return response()->json(['success' => false, 'message' => 'Không thể cập nhật trạng']);
    }


    public function orderHistory(Request $request)
    {
        $user = $request->user(); 
        $orderHistory = $this->cart->getUserOrderHistory($user); 

        return view('carts.order-history', [
            'title' => 'Lịch sử đặt hàng',
            'orderHistory' => $orderHistory, 
        ]);
    }
}

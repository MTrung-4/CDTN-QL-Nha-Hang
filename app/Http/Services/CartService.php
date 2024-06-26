<?php

namespace App\Http\Services;

use App\Jobs\SendMail;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function create($request)
    {
        $qty = (int)$request->input('num_product');
        $product_id = (int)$request->input('product_id');

        if ($qty <= 0 || $product_id <= 0) {
            Session::flash('error', 'Số lượng hoặc Sản phẩm không chính xác');
            return false;
        }

        $carts = Session::get('carts');
        if (is_null($carts)) {
            Session::put('carts', [
                $product_id => $qty
            ]);
            return true;
        }

        $exists = Arr::exists($carts, $product_id);
        if ($exists) {
            $carts[$product_id] = $carts[$product_id] + $qty;
            Session::put('carts', $carts);
            return true;
        }

        $carts[$product_id] = $qty;
        Session::put('carts', $carts);

        return true;
    }

    public function getProduct()
    {
        $carts = Session::get('carts');
        if (is_null($carts)) return [];

        $productId = array_keys($carts);
        return Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1)
            ->whereIn('id', $productId)
            ->get();
    }

    public function update($request)
    {
        Session::put('carts', $request->input('num_product'));

        return true;
    }

    public function remove($id)
    {
        $carts = Session::get('carts');
        unset($carts[$id]);

        Session::put('carts', $carts);
        return true;
    }

    public function addCart($request)
    {
        try {
            DB::beginTransaction();

            $carts = Session::get('carts');

            if (is_null($carts))
                return false;

            // Lấy user_id của người dùng đăng nhập (nếu có)
            $user_id = Auth::id();

            $customerData = [
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'time' => $request->input('time'),
                'qty' => $request->input('qty'),
                'email' => $request->input('email'),
                'content' => $request->input('content')
            ];

            // Nếu người dùng đã đăng nhập, thêm user_id vào dữ liệu của khách hàng
            if ($user_id) {
                $customerData['user_id'] = $user_id;
            }

            $customer = Customer::create($customerData);

            $this->infoProductCart($carts, $customer->id);

            // Lưu cart_id vào session
            Session::put('customer_id', $customer->id);

            DB::commit();

            Session::forget('carts');
        } catch (\Exception $err) {
            DB::rollBack();
            Session::flash('error', 'Đặt Hàng Lỗi, Vui lòng thử lại sau');
            return false;
        }

        return true;
    }

    protected function infoProductCart($carts, $customer_id)
    {
        $productId = array_keys($carts);
        $products = Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1)
            ->whereIn('id', $productId)
            ->get();

        $data = [];
        foreach ($products as $product) {
            $data[] = [
                'customer_id' => $customer_id,
                'product_id' => $product->id,
                'qty'   => $carts[$product->id],
                'price' => $product->price_sale != 0 ? $product->price_sale : $product->price
            ];
        }

        return Cart::insert($data);
    }

    public function getProductForCart($customer)
    {
        return $customer->carts()->with(['product' => function ($query) {
            $query->select('id', 'name', 'thumb');
        }])->get();
    }

    public function getTotalPriceForCustomer(Customer $customer)
    {
        $carts = $customer->carts()->get();

        $totalPrice = 0;
        foreach ($carts as $cart) {
            $totalPrice += $cart->price * $cart->qty;
        }

        return $totalPrice;
    }

    //lay danh sach don cho duyet
    public function getCustomerWithNullStatus()
    {
        return Customer::whereDoesntHave('carts', function ($query) {
            $query->whereNotNull('status');
        })->orderByDesc('id')->paginate(15);
    }

    //don dang xu ly
    public function getCustomer()
    {
        return Customer::whereHas('carts', function ($query) {
            $query->where('status', 1);
        })->orderByDesc('id')->paginate(9);
    }

    //lay danh sach don da huy
    public function getRejectCard()
    {
        return Cart::where('status', 0)->orderByDesc('updated_at')->paginate(15);
    }

    //danh sach don xu ly xong
    public function getApproveCard()
    {
        return Cart::whereNotNull('pay_option') 
            ->where('status', 2) 
            ->orderByDesc('updated_at') 
            ->paginate(15);
    }

    //luu phuong thuc thanh toan
    public function savePaymentOption(HttpRequest $request)
    {
        $cartId = $request->input('cart_id');
        $payOption = $request->input('pay_option');
        $payMoney = $request->input('pay_money');

        $cart = Cart::find($cartId);
        if ($cart) {
            $cart->pay_option = $payOption;
            $cart->pay_money = $payMoney;
            $cart->save();
            return ['success' => true, 'message' => 'Phương thức thanh toán đã được lưu thành công'];
        }

        return ['success' => false, 'message' => 'Không tìm thấy giỏ hàng'];
    }

    //duyet
    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 0;
    const STATUS_COMPLETED = 2; // Thêm hằng số mới cho trạng thái hoàn thành

    public function updateStatus($customerId, $status, $cancelReason = null)
    {
        if ($status === 'approved') {
            $status = self::STATUS_APPROVED;
        } elseif ($status === 'rejected') {
            $status = self::STATUS_REJECTED;
        } elseif ($status === 'completed') { // Thêm điều kiện cho trạng thái hoàn thành
            $status = self::STATUS_COMPLETED;
        }

        $cart = Cart::where('customer_id', $customerId)->first();
        if ($cart) {
            $cart->status = $status;

            // Nếu tồn tại lý do hủy, cập nhật trường cancel_reason
            if (!is_null($cancelReason)) {
                $cart->cancel_reason = $cancelReason;
            }

            $cart->save();
            return true;
        }
        return false;
    }


    public function getUserOrderHistory(User $user)
    {
        // Lấy danh sách đơn hàng của người dùng từ bảng Customer
        $customers = Customer::where('user_id', $user->id)->get();

        $orderHistory = [];

        // Duyệt qua từng đơn hàng của người dùng
        foreach ($customers as $customer) {
            // Truy xuất các đơn hàng tương ứng từ bảng Cart
            $carts = $customer->carts()->with('product')->get();

            // Lưu thông tin đơn hàng vào danh sách orderHistory
            $orderHistory[] = [
                'customer' => $customer,
                'carts' => $carts,
            ];
        }
        return $orderHistory;
    }
}

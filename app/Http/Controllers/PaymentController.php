<?php

namespace App\Http\Controllers;

use App\Jobs\SendMail;
use App\Models\Cart;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class PaymentController extends Controller
{
    public function vnpay_payment(Request $request)
    {
        $data = $request->all();
        $code_cart = rand(00, 9999);
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://nhahang.vtest/cart/callback?cart_id=" . $request->input('cart_id');
        $vnp_TmnCode = "L6F3PAKI"; //Mã website tại VNPAY
        $vnp_HashSecret = "OENYL9B734YNG8P50DVCO9JQSHTF9MSO"; //Chuỗi bí mật

        $vnp_TxnRef = $data['cart_id'];
        //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh Toán Hóa Đơn';
        $vnp_OrderType = 'Yen Restaurant';/*  */
        $vnp_Amount = $data['total'] * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
    }

    public function handlePaymentCallback(Request $request)
    {
        $cartId = $request->input('cart_id');

        // Truy vấn cơ sở dữ liệu để lấy thông tin liên quan đến đơn hàng
        $cart = Cart::find($cartId);

        // Log thông tin đơn hàng
        if ($cart) {

            // Lấy thông tin khách hàng từ đơn hàng
            $customerId = $cart->customer_id;
            $customer = Customer::find($customerId);
        } else {
            Log::error('Cart not found with ID: ' . $cartId);
        }

        $vnp_ResponseCode = '01';  // Giả lập mã phản hồi thất bại
        /* $vnp_ResponseCode = $request->input('vnp_ResponseCode'); */

        if ($vnp_ResponseCode === '00') {
            SendMail::dispatch($customer->email, $customer)->delay(now()->addSeconds(2));
            return view('vnpay.success');
        } else {
            // Xóa thông tin đơn hàng và khách hàng liên quan
            if ($cart) {
                $cart->delete();
            }
            if ($customer) {
                $customer->delete();
            }
            Log::info('Order and customer data deleted due to failed payment');

            return view('vnpay.failure');
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function generatePDF($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        $cartItems = Cart::where('customer_id', $customerId)->get();

        $data = [
            'title' => 'Hóa Đơn',
            'customer' => $customer,
            'cartItems' => $cartItems,
        ];

        $pdf = Pdf::loadView('admin.carts.invoice', $data);

        return $pdf->download('hoadon.pdf');
    }
}

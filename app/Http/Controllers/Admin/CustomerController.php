<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Customer\CustomerService;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $customer;


    public function __construct(CustomerService $customer)
    {
        $this->customer = $customer;
    }

    public function create()
    {
        
        return view('admin.customer.add', [
            'title' => 'Thêm Khách Hàng Mới',
        ]);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'phone' => 'required',
            'email' => 'required',
        ], [
            'name.required' => 'Tên Khách Hàng không được để trống',
            'email.required' => 'Email không được để trống',
            'phone.required' => 'Số Điện Thoại không được để trống'
        ]);
        $this->customer->insert($request);

        return redirect()->back();
    }

    public function index()
    {
        return view('admin.customer.list', [
            'title' => 'Danh Sách Khách Hàng',
            'customers' => $this->customer->get()
        ]);
    }

    public function edit(Customer $customer)
    {
        return view('admin.customer.edit', [
            'title' => 'Chỉnh Sửa Khách Hàng',
            'customer' => $customer,
        ]);
    }

    public function update(Request $request, Customer $customer)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'phone' => 'required',
            'email' => 'required',
        ], [
            'name.required' => 'Tên Khách Hàng không được để trống',
            'email.required' => 'Email không được để trống',
            'phone.required' => 'Số Điện Thoại không được để trống'
        ]);

        $result = $this->customer->update($request, $customer);
        if ($result) {
            return redirect('/admin/customers/list');
        }
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $result = $this->customer->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công Khách Hàng'
            ]);
        }

        return response()->json(['error' => true]);
    }

    public function showCustomers() {
        $selectedTable = session('selectedTable');
        return view('admin.carts.customer', ['selectedTable' => $selectedTable]);
    }
    
    
    
}

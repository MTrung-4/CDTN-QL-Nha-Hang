<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function show()
    { // Lấy thông tin của tất cả khách hàng
        $customers = Customer::select('name', 'phone', 'email')->get();

        // Tạo mảng để lưu trữ số lần xuất hiện của mỗi khách hàng
        $counts = [];

        // Đếm số lần xuất hiện của từng khách hàng
        foreach ($customers as $customer) {
            $key = $customer->name . '-' . $customer->phone . '-' . $customer->email;
            if (!isset($counts[$key])) {
                $counts[$key] = 1;
            } else {
                $counts[$key]++;
            }
        }

        // Lọc ra những khách hàng có số lần xuất hiện > 1
        $duplicates = collect([]);
        $uniqueCustomers = collect([]);

        foreach ($counts as $key => $count) {
            [$name, $phone, $email] = explode('-', $key);
            $customer = ['name' => $name, 'phone' => $phone, 'email' => $email, 'count' => $count];
            if ($count > 1) {
                $duplicates->push($customer);
            } else {
                $uniqueCustomers->push($customer);
            }
        }

        // Sắp xếp danh sách khách hàng trùng lặp theo số lần trùng lặp giảm dần
        $sortedDuplicates = $duplicates->sortByDesc('count');

        // Ghép danh sách khách hàng trùng lặp và không trùng lặp
        $sortedCustomers = $sortedDuplicates->merge($uniqueCustomers);
        return view('admin.customer.list', [
            'title' => 'Danh Sách Khách Hàng',
            'customers' =>  $sortedCustomers
        ]);
    }
}

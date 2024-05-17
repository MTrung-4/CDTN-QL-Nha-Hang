<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole:admin, staff');
    }

    public function show()
    {
        // Lấy thông tin của tất cả khách hàng
        $this->authorize('show', Customer::class);
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

        // Phân trang tập hợp khách hàng đã sắp xếp
        $paginatedCustomers = $this->paginateCollection($sortedCustomers, 10);

        return view('admin.customer.list', [
            'title' => 'Danh Sách Khách Hàng',
            'customers' => $paginatedCustomers
        ]);
    }

    /**
     * Phân trang cho một tập hợp hoặc mảng các mục.
     *
     * @param  \Illuminate\Support\Collection|array  $items
     * @param  int  $perPage
     * @param  string  $pageName
     * @param  null|int  $page
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function paginateCollection($items, $perPage = 10, $pageName = 'page', $page = null)
    {
        $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $paginatedItems = $items->slice(($page - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator($paginatedItems, $items->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
    }
}

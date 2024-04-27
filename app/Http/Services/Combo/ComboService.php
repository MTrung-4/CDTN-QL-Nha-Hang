<?php

namespace App\Http\Services\Combo;

use App\Models\Combo;
use App\Models\Item;
use App\Models\Product;

class ComboService
{
    public function getAllProducts()
    {
        return Product::where('active', 1)->get();
    }

    public function getAllItems()
    {
        return Item::with('products')->where('active', 1)->get();
    }

    public function getComboById($id)
    {
        $combo = Combo::findOrFail($id);
        $selectedProducts = $combo->products()->pluck('id')->toArray(); // Lấy danh sách sản phẩm đã chọn
        $selectedItems = $combo->items()->pluck('id')->toArray(); // Lấy danh sách item đã chọn
        return [
            'combo' => $combo,
            'selectedProducts' => $selectedProducts,
            'selectedItems' => $selectedItems
        ];
    }

    public function get()
    {
        return Combo::where('active', 1)
            ->orderByDesc('id')->paginate(10);
    }

    public function createCombo($data)
    {
        $combo = Combo::create([
            'name' => $data['name'],
            'price_combo' => $data['price_combo'],
            'description' => $data['description'],
            'active' => isset($data['active']) ? $data['active'] : 0,
            'max_order' => $data['max_order'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'promotion' => $data['promotion'],
        ]);

        // Thêm các sản phẩm được chọn vào combo mới
        if (isset($data['products']) && is_array($data['products'])) {
            $combo->products()->attach($data['products']);
        }

        // Thêm các item được chọn vào combo mới
        if (isset($data['items']) && is_array($data['items'])) {
            $combo->items()->attach($data['items']);
        }

        return $combo;
    }

   /*  public function updateCombo($id, array $data)
    {
        $combo = Combo::findOrFail($id);
        $combo->update($data);

        // Cập nhật lại danh sách sản phẩm
        if (isset($data['products']) && is_array($data['products'])) {
            $combo->products()->sync($data['products']);
        } else {
            $combo->products()->detach(); // Nếu không có sản phẩm nào được chọn, xóa hết các sản phẩm đã có
        }

        // Cập nhật lại danh sách item
        if (isset($data['items']) && is_array($data['items'])) {
            $combo->items()->sync($data['items']);
        } else {
            $combo->items()->detach(); // Nếu không có item nào được chọn, xóa hết các item đã có
        }

        return $combo;
    }

    public function deleteCombo($id)
    {
        $combo = Combo::find($id);
        if ($combo) {
            $combo->delete();
            return true;
        }

        return false;
    } */
}

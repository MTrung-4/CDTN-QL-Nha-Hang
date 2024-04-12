<?php

namespace App\Http\Services\Item;

use App\Models\Item;
use App\Models\Product;

class ItemService
{
    public function getAllProducts()
    {
        return Product::where('active', 1)->get();
    }

    public function getItemById($id)
    {
        $item = Item::findOrFail($id);
        $selectedProducts = $item->products()->pluck('id')->toArray(); // Lấy danh sách sản phẩm đã chọn
        return [
            'item' => $item,
            'selectedProducts' => $selectedProducts,
        ];
    }


    public function get()
    {
        return Item::where('active', 1)
            ->orderByDesc('id')->paginate(10);
    }

    public function createItem($data)
    {
        $item = Item::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description'],
            'active' => isset($data['active']) ? $data['active'] : 0,
        ]);

        // Nếu dữ liệu sản phẩm được truyền vào hợp lệ
        if (isset($data['products']) && is_array($data['products'])) {
            // Thêm các sản phẩm vào item mới
            $item->products()->attach($data['products']);
        }

        // Trả về item mới đã tạo
        return $item;
    }

    public function updateItem($id, array $data)
    {
        $itemData = $this->getItemById($id); // Lấy dữ liệu của item
        $item = $itemData['item']; // Truy cập item từ dữ liệu lấy được

        $item->update($data);

        // Cập nhật lại danh sách sản phẩm
        $item->products()->sync($data['products']);

        return $item;
    }

    public function deleteItem($id)
    {
        $item = Item::find($id);
        if ($item) {
            $item->delete();
            return true;
        }

        return false;
    }
}

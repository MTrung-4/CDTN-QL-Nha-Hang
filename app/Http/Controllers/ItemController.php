<?php

namespace App\Http\Controllers;

use App\Http\Services\Item\ItemService;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    protected $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    public function showItem()
    {
        $items = $this->itemService->getAllItems();
        return view('Item.web_item', [
            'title' => 'Thực đơn',
            'items' => $items
        ]);
    }
}

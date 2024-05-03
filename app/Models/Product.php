<?php

namespace App\Models;

use App\Models\Admin\MenuItems;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'unit',
        'price',
        'price_sale',
        'active',
        'thumb',
        'description',
        'menu_id',
        'content'
    ];
    public function menu()
    {
        return $this->hasOne(Menu::class, 'id', 'menu_id')
            ->withDefault(['name' => '']);
    }

    public function item()
    {
        return $this->belongsToMany(Item::class);
    }

    public function combo()
    {
        return $this->belongsToMany(Combo::class);
    }
}

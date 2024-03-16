<?php

namespace App\Models;

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
        'menu_id'
    ];
    public function menu()
    {
        return $this->hasOne(Menu::class, 'id', 'menu_id')
            ->withDefault(['name' => '']);
    }
}

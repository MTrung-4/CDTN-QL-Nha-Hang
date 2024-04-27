<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Combo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price_combo',
        'description',
        'active',
        'max_order',
        'start_date',
        'end_date',
        'promotion',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
}

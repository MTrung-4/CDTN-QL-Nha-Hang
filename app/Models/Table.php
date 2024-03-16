<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = ['name', 'active', 'capacity'];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function inStock()
    {
        return $this->stock()->where('in_stock', true)->exists();
        //return all the stick associated with this product id where the in_stock attribute is true
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }
}

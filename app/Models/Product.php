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

    public function track()
    {
        $this->stock->each->track();
        //this product has stock at different retailer, we need to track them
        //for each product it is stock in many locations.
        //a prduct can track all of its stock. ie where it exists and also a single piece of stock
        // can be tracked
        //grap stock associated with each product


    }
}

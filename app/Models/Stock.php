<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Stock extends Model
{
    use HasFactory;
    protected $table = 'stock';
    //because we didn't use stock plural we set the table name explicitly

    protected $casts = [
        'in_stock' => 'boolean'
    ];
    //casting in stock to a boolean for our db
    //stored as 1 or 0 in db

    public function track($callback = null) //if you receive a callback trigger the function and pass through the stock instance
    {
        //$status will be our stock status object which is returned from the checkavalibaility method

        $status = $this->retailer
            ->client()
            ->checkAvailability($this);


        $this->update([
            'in_stock' => $status->available,
            'price' => $status->price
        ]);


        $callback && $callback($this);

        //we check availability
        //we update the db
        //if callback it provited we trigger it


    }

//    protected function recordHistory(): void
//    {
//        $this->history()->create([
//            'price' => $this->price,
//            'in_stock' => $this->in_stock,
//            'product_id' => $this->product_id
//        ]);
//    }



    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }



}

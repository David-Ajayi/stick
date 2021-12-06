<?php

namespace App\Models;

use App\UseCases\TrackStock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use App\Events\NowInStock;


class Stock extends Model
{

    protected $table = 'stock';
    //because we didn't use stock plural we set the table name explicitly

    protected $casts = [
        'in_stock' => 'boolean'
    ];
    //casting in stock to a boolean for our db
    //stored as 1 or 0 in db

//    public function track()
    public function track()
    {
        //$status will be our stock status object which is returned from the checkavalibaility method
        (new TrackStock($this))->handle(); //pass through the stock to TrackStock use case

//        TrackStock::dispatch($this);



    }




    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }



}

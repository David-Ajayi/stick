<?php

namespace App\Clients;

use App\Models\Stock;
use Illuminate\Support\Facades\Http;

class FakeStore implements Client

{
    public function checkAvailability(Stock $stock): StockStatus
    {

        $results = Http::get($this->endpoint($stock->sku))->json();
//        dd($results['price']);

        return new StockStatus(
            true,
//            (int) $results['salePrice'] * 100 //our db save price in pennies
            $results['price']

        );

    }
//    stock status is a class. We need to find a way to normalise the data recieved from each
//    api for our test. here bestbut is returning the keys 'available ' and 'price'


    protected function endpoint($sku): string
    {


//        dd($key);

        return "https://fakestoreapi.com/products/{$sku}";
    }
}

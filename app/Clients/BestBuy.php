<?php

namespace App\Clients;


use App\Models\Stock;
use Illuminate\Support\Facades\Http;

class BestBuy implements Client
{
    public function checkAvailability(Stock $stock): StockStatus
    {
//        $results = Http::get('http://foo.test')->json();
        $results = Http::get($this->endpoint($stock->sku))->json();
//        dd($results);

        return new StockStatus(
//            $results['available'],
//            $results['price']
            $results['onlineAvailability'],
//            (int) $results['salePrice'] * 100 //our db save price in pennies
        $this->poundsToPennies($results['salePrice'])

        );

    }
//    stock status is a class. We need to find a way to normalise the data recieved from each
//    api for our test. here bestbut is returning the keys 'available ' and 'price'


    protected function endpoint($sku): string
    {
        $key = config('services.clients.bestBuy.key');

//        dd($key);

        return "https://api.bestbuy.com/v1/products/{$sku}.json?apiKey={$key}";
    }


    protected function poundsToPennies($salePrice)
    {
        return (int) ($salePrice * 100);
    }

}

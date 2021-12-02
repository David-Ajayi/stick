<?php

namespace Tests\Unit;

use App\Models\History;
use App\Models\Product;
use Tests\TestCase;
use RetailerWithProductSeeder;
use App\Clients\StockStatus;
use Illuminate\Support\Facades\Http;
use Facades\App\Clients\ClientFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductHistoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_records_history_when_a_product_is_tracked()
    {
        $this->seed(RetailerWithProductSeeder::class);

//        Http::fake(fn() => ['salePrice' => 99, 'onlineAvailability' => true]);

        ClientFactory::shouldReceive('make->checkAvailability')
            ->andReturn(new StockStatus($available = true, $price = 99));
        //we dont want to make api calls for the purpose of this test

//        $this->assertEquals(0, History::count());

        $product = tap(Product::first(), function ($product) {
            $this->assertCount(0, $product->history);
            //before we run there should be no entries in the history table

//        $stock = tap(Stock::first())->track();
        $product->track();

//        $this->assertEquals(1, History::count());
        $this->assertCount(1, $product->refresh()->history); //we need to refresh to get the new db state which should have a history row now
        });

        $history = History::first();


        $history = $product->history->first();
        $this->assertEquals($price, $history->price);
        $this->assertEquals($available, $history->in_stock);
        $this->assertEquals($product->stock[0]->id, $history->stock_id);
    }
}

//everytime we track stock history entry should be created
//given i have stock at a reatailer
//If I track that stock
//a new history entry should be created
//the hsitory tabkle does't keep history of stock at any one retailer.
//istead it shows the availability and pricing history regardless of stock across all retailer

<?php

namespace Tests\Unit;

use App\Models\Stock;
use App\Models\History;
use Tests\TestCase;
use RetailerWithProductSeeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductHistoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_records_history_each_time_stock_is_tracked()
    {
        $this->seed(RetailerWithProductSeeder::class);

        Http::fake(fn() => ['salePrice' => 99, 'onlineAvailability' => true]);

        $this->assertEquals(0, History::count());
        //before we run there should be no entries in the history table

        $stock = tap(Stock::first())->track();

        $this->assertEquals(1, History::count());

        $history = History::first();

        $this->assertEquals($stock->price, $history->price);
        $this->assertEquals($stock->in_stock, $history->in_stock);
        $this->assertEquals($stock->product_id, $history->product_id);
        $this->assertEquals($stock->id, $history->stock_id);
    }
}

//everytime we track stock history entry should be created
//given i have stock at a reatailer
//If I track that stock
//a new history entry should be created

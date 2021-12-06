<?php

namespace Tests\Unit;

use App\Models\Stock;
use App\Models\Retailer;
use Tests\TestCase;
use RetailerWithProductSeeder;
use App\Clients\ClientException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\App\Clients\ClientFactory;
use App\Clients\StockStatus;

class StockTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_throws_an_exception_if_a_client_is_not_found_when_tracking()
        // given I have a retailer with stock
        //If I track the stock for that retailer
        //if that retailer doesn't have a Client class
        //Throw an exception
    {
        $this->seed(RetailerWithProductSeeder::class);

        Retailer::first()->update(['name' => 'non existent Retailer']);


        $this->expectException(ClientException::class);

        Stock::first()->track();


    }


//     /** @test */
//    function it_updates_local_stock_status_after_being_tracked()
//        //client factory to determine appropriate client
//
//    {
//
//
//        $this->seed(RetailerWithProductSeeder::class);
//
////        ClientFactory::shouldReceive('make->checkAvailability')->andReturn(
////            new StockStatus($available = true, $price = 9900)
////        );
//        $this->mockClientRequest($available = false, $price = 100);
//
//        //I want to intercept 'make' at the makingfor testing
//        //in client factory to checkavailability()
//
//
////        $stock = tap(Stock::first())->track();
//        $stock = Stock::first()->track();
//        $stock = Stock::first();
//        $stock->track();
////        dd($stock);
////        $status = $this->retailer
////            ->client()
////            ->checkAvailability($this);
////        $stock = Stock::first()->track();
////        dd($stock);
//
//        $this->assertFalse($stock->in_stock);
//        $this->assertEquals(100, $stock->price);
//
//    }




}

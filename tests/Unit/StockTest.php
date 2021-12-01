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

        Retailer::first()->update(['name' => 'Foo Retailer']);

        $this->expectException(ClientException::class);

        Stock::first()->track();
    }


     /** @test */
    function it_updates_local_stock_status_after_being_tracked()
        //client factory to determine appropriate client
        //checkavilability
    {


        $this->seed(RetailerWithProductSeeder::class);

        ClientFactory::shouldReceive('make->checkAvailability')->andReturn(
            new StockStatus($available = true, $price = 9900)
        );
        //I don't want to make a new client I want to intercept 'make' for testing
        //client factory should recieve a call to make the check availability on
        //that result

        $stock = tap(Stock::first())->track();

        $this->assertTrue($stock->in_stock);
        $this->assertEquals(9900, $stock->price);
    }




}

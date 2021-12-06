<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Retailer;
use Tests\TestCase;
//use App\Clients\StockStatus;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RetailerWithProductSeeder;
//use Facades\App\Clients\ClientFactory;
use App\Notifications\ImportantStockUpdate;
use Illuminate\Support\Facades\Notification;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;
//
//    /**
//     * Setup the test environment.
//     *
//     * @return void
//     */
//    protected function setUp(): void
    /** @test */
    function it_tracks_product_stock()
    {
        Notification::fake();

        $this->seed(RetailerWithProductSeeder::class);

        $this->assertFalse(Product::first()->inStock());

        $this->mockClientRequest();

        $this->artisan('track')
            ->expectsOutput('All done!');

        $this->assertTrue(Product::first()->inStock());
    }




//    /** @test */
//    function it_does_not_notify_the_user_when_the_stock_is_unavailable()
//    {
//        $this->mockClientRequest($available = false);
//
//        $this->artisan('track');
//
//        Notification::assertNothingSent();
//        //if a products is out of stock
//        //we update and check availability
//        //no notification should be sent
//    }
//
//    /** @test */
//    function it_notifies_the_user_when_the_stock_becomes_available()
//    {
//        $this->mockClientRequest();
//
//        $this->artisan('track');
//
//        Notification::assertSentTo(User::first(), ImportantStockUpdate::class);
//    }





}

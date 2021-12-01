<?php

namespace Tests\Feature;

use App\Models\Stock;
use App\Models\Product;
use App\Models\Retailer;
use Tests\TestCase;
use App\Clients\StockStatus;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RetailerWithProductSeeder;
use Facades\App\Clients\ClientFactory;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_tracks_product_stock()
    {
        $this->seed(RetailerWithProductSeeder::class);

//        dd(Product::all());

        $this->assertFalse(Product::first()->inStock());

//        Http::fake(fn() => ['available' => true, 'price' => 29900]);
        ClientFactory::shouldReceive('make->checkAvailability')
            ->andReturn(new StockStatus($available = true, $price = 29900));

        $this->artisan('track')
            ->expectsOutput('All done!');


        $this->assertTrue(Product::first()->inStock());

    }
}

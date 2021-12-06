<?php

namespace Tests\Feature;



use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use RetailerWithProductSeeder;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    //It is often useful to reset your database after each test
    //so that data from a previous test does not interfere with subsequent tests
    use RefreshDatabase;

    /** @test */
    public function it_checks_stock_for_products_at_retailers()
    {
        $this->seed(RetailerWithProductSeeder::class);
        //create Product, creates a retailer, adds the stock to the retailer
//        $product = Product::first();
//        $this->assertFalse($product->inStock());
//        $product->stock()->first()->update(['in_stock' => true]);
//        $this->assertTrue($product->inStock());

        tap(Product::first(), function ($product) {
//            dd($product);
            $this->assertFalse($product->inStock());

            $product->stock()->first()->update(['in_stock' => true]);

            $this->assertTrue($product->inStock());
        });

    }
}

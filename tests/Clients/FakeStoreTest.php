<?php

namespace Tests\Clients;
use App\Clients\FakeStore;
use App\Models\Stock;
use Tests\TestCase;
use RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

/**
 * @group api
 */
class FakeStoreTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_tracks_a_product()
    {
        $this->seed(RetailerWithProductSeeder::class);

        $stock = tap(Stock::first())->update([
            'sku' => '11', // fake sku which is the id for this laptop product at the fakestore api
            'url' => 'https://www.bestbuy.com/site/nintendo-switch-32gb-console-gray-joy-con/6364253.p?skuId=6364253'
        ]);

        try {
            (new FakeStore())->checkAvailability($stock);
        } catch (\Exception $e) {
//            $this->fail('Failed to track the BestBuy API properly.');
            $this->fail('Failed to track the FakeStore API properly. ' . $e->getMessage());
        }

        $this->assertTrue(true);
    }



}

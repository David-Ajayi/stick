<?php

namespace App\UseCases;

use App\Models\User;
use App\Models\Stock;
use App\Models\History;
use App\Clients\StockStatus;
use Illuminate\Queue\SerializesModels;
use App\Notifications\ImportantStockUpdate;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;

class TrackStock implements ShouldQueue
{
    use Dispatchable, SerializesModels;

    protected Stock $stock;

    protected StockStatus $status;

    public function __construct(Stock $stock) //we are no longer in the stock model so we need to
        //keep reference to the stock model
    {
        $this->stock = $stock;
    }

    public function handle()//this handle method triggers these steps.
    {
        $this->checkAvailability();

        $this->notifyUser();
        $this->refreshStock();
        $this->recordToHistory();
    }

    protected function checkAvailability()
    {
        $this->status = $this->stock
            ->retailer
            ->client()
            ->checkAvailability($this->stock);
    }
   // notify the user
    protected function notifyUser()
    {
        if (! $this->stock->in_stock && $this->status->available) {
            User::first()->notify(
                new ImportantStockUpdate($this->stock) //fire event here
            );
        }
    }
    //refresh stock
    protected function refreshStock()
    {
        $this->stock->update([
            'in_stock' => $this->status->available,
            'price' => $this->status->price
        ]);
    }
   //record to history
    protected function recordToHistory()
    {
        History::create([
            'price' => $this->stock->price,
            'in_stock' => $this->stock->in_stock,
            'product_id' => $this->stock->product_id,
            'stock_id' => $this->stock->id
        ]);
    }


}

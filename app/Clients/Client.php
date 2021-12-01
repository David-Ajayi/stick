<?php

namespace App\Clients;
use App\Models\Stock;

interface Client
{
    public function checkAvailability(Stock $stock): StockStatus;
    //if we implement this api we must return a Stock Status

}

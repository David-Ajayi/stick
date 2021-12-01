<?php

namespace App\Clients;

use App\Models\Retailer;
use Illuminate\Support\Str;

class ClientFactory
{
    public function make(Retailer $retailer): Client
    {
        $class = "App\\Clients\\" . Str::studly($retailer->name);

        if (! class_exists($class)) {
            throw new ClientException('Client not found for ' . $retailer->name);
        }

        return new $class;
    }
}
//return instance of class created could be best buy, target, amazon, game, hamleys
//factory creates a object instance
//this class figures out the appropriate client instance
//checks our clients dir for the retailer name retailer passed to it

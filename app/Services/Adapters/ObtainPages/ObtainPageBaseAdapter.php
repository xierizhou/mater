<?php


namespace App\Services\Adapters\ObtainPages;

use GuzzleHttp\Client;
class ObtainPageBaseAdapter
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }
}
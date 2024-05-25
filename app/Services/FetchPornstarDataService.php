<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FetchPornstarDataService
{
    public function fetchData()
    {
        $response = Http::get('https://www.pornhub.com/files/json_feed_pornstars.json');

        if ($response->failed()) {
            throw new \Exception('Failed to fetch data');
        }

        return $response->json();
    }
}


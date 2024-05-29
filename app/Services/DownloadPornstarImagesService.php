<?php

namespace App\Services;

use App\Interfaces\Repositories\ThumbnailRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;

class DownloadPornstarImagesService
{
    protected $thumbnailRepo;
    protected $client;
    protected $concurrency;

    public function __construct(ThumbnailRepositoryInterface $thumbnailRepo, $concurrency = 20)
    {
        $this->thumbnailRepo = $thumbnailRepo;
        $this->client = new Client();
        $this->concurrency = $concurrency;
    }

    public function downloadImages($flushRedis = false)
    {
        if ($flushRedis) {
            Redis::flushdb();
        }

        $thumbnails = $this->thumbnailRepo->getAll();
        $requests = function ($thumbnails) {
            foreach ($thumbnails as $thumbnail) {
                yield new Request('GET', urldecode($thumbnail->url));
            }
        };

        $pool = new Pool($this->client, $requests($thumbnails), [
            'concurrency' => $this->concurrency,
            'fulfilled' => function ($response, $index) use ($thumbnails) {
                $thumbnail = $thumbnails[$index];
                $this->cacheImage($response->getBody(), $thumbnail->pornstar_id, $thumbnail->type);
            },
            'rejected' => function ($reason, $index) {
                Log::error("Error downloading image: " . $reason);
            },
        ]);

        $promise = $pool->promise();
        $promise->wait();
    }

    private function cacheImage($imageContent, $pornstarId, $type)
    {
        $key = "pornstar_image:{$pornstarId}_{$type}";

        if (!Redis::exists($key)) {
            $compressedImage = gzcompress($imageContent);
            Redis::set($key, $compressedImage);
        }
    }
}

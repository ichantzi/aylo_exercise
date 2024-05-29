<?php

namespace App\Services;

use App\Interfaces\Repositories\ThumbnailRepositoryInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class DownloadPornstarImagesService
{
    protected $thumbnailRepo;

    public function __construct(ThumbnailRepositoryInterface $thumbnailRepo)
    {
        $this->thumbnailRepo = $thumbnailRepo;
    }

    public function downloadImages()
    {
        ini_set('memory_limit', '256M'); // Set memory limit to 256 megabytes

        $thumbnails = $this->thumbnailRepo->getAll();

        foreach ($thumbnails as $thumbnail) {
            $this->cacheImage($thumbnail->url, $thumbnail->pornstar_id, $thumbnail->type);
        }
    }

    private function cacheImage($url, $pornstarId, $type)
    {
        $decodedUrl = urldecode($url);
        $cacheKey = $this->generateCacheKey($decodedUrl, $pornstarId, $type);

        if (!Redis::exists($cacheKey)) {
            try {
                $image = Http::get($decodedUrl)->body();
                Redis::set($cacheKey, $image);
                Redis::expire($cacheKey, 604800);
            } catch (\Exception $e) {
                Log::error("Error downloading or caching image: " . $e->getMessage());
            }
        }

        return $cacheKey;
    }

    private function generateCacheKey($url, $pornstarId, $type)
    {
        return 'image:' . $pornstarId . ':' . $type . ':' . md5($url);
    }
}

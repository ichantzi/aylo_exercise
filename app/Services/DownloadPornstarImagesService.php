<?php

namespace App\Services;

use App\Interfaces\Repositories\ThumbnailRepositoryInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DownloadPornstarImagesService
{
    protected $thumbnailRepo;

    public function __construct(ThumbnailRepositoryInterface $thumbnailRepo)
    {
        $this->thumbnailRepo = $thumbnailRepo;
    }

    public function downloadImages()
    {
        $thumbnails = $this->thumbnailRepo->getAll();

        foreach ($thumbnails as $thumbnail) {
            $this->cacheImage($thumbnail->url, $thumbnail->pornstar_id, $thumbnail->type);
        }
    }

    private function cacheImage($url, $pornstarId, $type)
    {
        $decodedUrl = urldecode($url);

        $directory = "public/pornstars/{$pornstarId}/{$type}";
        if (!Storage::exists($directory)) {
            Storage::makeDirectory($directory);
        }

        $filename = basename($decodedUrl);
        $filePath = "{$directory}/{$filename}";

        if (!Storage::exists($filePath)) {
            $image = Http::get($decodedUrl)->body();
            Storage::put($filePath, $image);
        }

        return Storage::url($filePath);
    }
}

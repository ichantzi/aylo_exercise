<?php

namespace App\Repositories;

use App\Interfaces\Repositories\ThumbnailRepositoryInterface;
use App\Models\Thumbnail;

class ThumbnailRepository implements ThumbnailRepositoryInterface
{
    public function upsert(array $data)
    {
        foreach ($data as $item) {
            Thumbnail::updateOrCreate(
                ['pornstar_id' => $item['pornstar_id'], 'url' => $item['url'], 'type' => $item['type']],
                $item
            );
        }
    }

    public function getAll()
    {
        return Thumbnail::all();
    }
}

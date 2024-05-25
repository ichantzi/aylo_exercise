<?php

namespace App\Repositories;

use App\Interfaces\Repositories\ThumbnailRepositoryInterface;
use App\Models\Thumbnail;

class ThumbnailRepository implements ThumbnailRepositoryInterface
{
    public function upsert($data)
    {
        return Thumbnail::upsert($data, ['pornstar_id', 'type'], ['height', 'width', 'url', 'updated_at']);
    }
}

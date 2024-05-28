<?php

namespace App\Repositories;

use App\Interfaces\Repositories\PornstarStatsRepositoryInterface;
use App\Models\PornstarStats;

class PornstarStatsRepository implements PornstarStatsRepositoryInterface
{
    public function upsert(array $data)
    {
        foreach ($data as $item) {
            PornstarStats::updateOrCreate(
                ['pornstar_id' => $item['pornstar_id']],
                $item
            );
        }
    }
}

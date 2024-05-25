<?php

namespace App\Repositories;

use App\Interfaces\Repositories\PornstarStatsRepositoryInterface;
use App\Models\PornstarStats;

class PornstarStatsRepository implements PornstarStatsRepositoryInterface
{
    public function upsert($data)
    {
        return PornstarStats::upsert($data, ['pornstar_id'], ['subscriptions', 'monthlySearches', 'views', 'videosCount', 'premiumVideosCount', 'whiteLabelVideoCount', 'rank', 'rankPremium', 'rankWl', 'updated_at']);
    }
}

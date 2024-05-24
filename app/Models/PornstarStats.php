<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PornstarStats extends Model
{
    protected $fillable = [
        'pornstar_id', 'subscriptions', 'monthlySearches', 'views',
        'videosCount', 'premiumVideosCount', 'whiteLabelVideoCount', 'rank',
        'rankPremium', 'rankWl'
    ];

    public function pornstar()
    {
        return $this->belongsTo(Pornstar::class);
    }
}

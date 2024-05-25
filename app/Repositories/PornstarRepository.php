<?php

namespace App\Repositories;

use App\Interfaces\Repositories\PornstarRepositoryInterface;
use App\Models\Pornstar;

class PornstarRepository implements PornstarRepositoryInterface
{
    public function upsert($data)
    {
        return Pornstar::upsert($data, ['pornhub_id'], ['name', 'link', 'license', 'wlStatus', 'hairColor', 'ethnicity', 'tattoos', 'piercings', 'breastSize', 'breastType', 'gender', 'orientation', 'age', 'updated_at']);
    }
}

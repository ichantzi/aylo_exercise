<?php

namespace App\Repositories;

use App\Interfaces\Repositories\AliasRepositoryInterface;
use App\Models\Alias;

class AliasRepository implements AliasRepositoryInterface
{
    public function upsert(array $data)
    {
        foreach ($data as $item) {
            Alias::updateOrCreate(
                ['pornstar_id' => $item['pornstar_id'], 'alias' => $item['alias']],
                $item
            );
        }
    }
}

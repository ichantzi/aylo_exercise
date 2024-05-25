<?php

namespace App\Repositories;

use App\Interfaces\Repositories\AliasRepositoryInterface;
use App\Models\Alias;

class AliasRepository implements AliasRepositoryInterface
{
    public function upsert($data)
    {
        return Alias::upsert($data, ['pornstar_id', 'alias'], ['updated_at']);
    }
}

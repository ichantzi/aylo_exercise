<?php

namespace App\Interfaces\Repositories;

interface AliasRepositoryInterface
{
    public function upsert(array $data);

}

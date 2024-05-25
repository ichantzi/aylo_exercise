<?php

namespace App\Interfaces\Repositories;

interface ThumbnailRepositoryInterface
{
    public function upsert(array $data);

}

<?php

namespace App\Interfaces\Repositories;

interface PornstarRepositoryInterface
{
    public function upsert(array $data);

    public function getPornstarIdMapping();

    public function find($id);


}


<?php

namespace App\Repositories;

use App\Interfaces\Repositories\PornstarRepositoryInterface;
use App\Models\Pornstar;

class PornstarRepository implements PornstarRepositoryInterface
{
    public function upsert(array $data)
    {
        foreach ($data as $item) {
            Pornstar::updateOrCreate(
                ['pornhub_id' => $item['pornhub_id']],
                $item
            );
        }
    }

    public function getPornstarIdMapping()
    {
        return Pornstar::pluck('id', 'pornhub_id');
    }

    public function find($id)
    {
        return Pornstar::with('thumbnails', 'aliases', 'stats')->findOrFail($id);
    }


    public function searchByName(string $name)
    {
        return Pornstar::where('name', 'like', "%{$name}%")->get();
    }
}

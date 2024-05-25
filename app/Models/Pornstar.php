<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pornstar extends Model
{
    protected $fillable = [
        'pornhub_id','name', 'link', 'license', 'wlStatus', 'hairColor', 'ethnicity',
        'tattoos', 'piercings', 'breastSize', 'breastType', 'gender', 'orientation', 'age'
    ];

    public function stats()
    {
        return $this->hasOne(PornstarStats::class);
    }

    public function aliases()
    {
        return $this->hasMany(Alias::class);
    }

    public function thumbnails()
    {
        return $this->hasMany(Thumbnail::class);
    }
}

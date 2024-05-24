<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thumbnail extends Model
{
    protected $fillable = ['pornstar_id', 'height', 'width', 'type', 'url', 'local_path'];

    public function pornstar()
    {
        return $this->belongsTo(Pornstar::class);
    }
}

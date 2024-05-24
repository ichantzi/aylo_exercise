<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alias extends Model
{
    protected $fillable = ['pornstar_id', 'alias'];

    public function pornstar()
    {
        return $this->belongsTo(Pornstar::class);
    }
}

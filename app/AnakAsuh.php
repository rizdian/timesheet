<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnakAsuh extends Model
{
    public function donaturs()
    {
        return $this->belongsToMany(Donatur::class);
    }
}

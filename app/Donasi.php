<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    public function donatur(){
        return $this->belongsTo(Donatur::class);
    }
}

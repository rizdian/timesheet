<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donatur extends Model
{
    public function donasis(){
        return $this->hasMany(Donasi::class);
    }
    public function anakasuhs()
    {
        return $this->belongsToMany(AnakAsuh::class);
    }
}

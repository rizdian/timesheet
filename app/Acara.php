<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acara extends Model
{
    public function donasis(){
        return $this->hasMany(Donasi::class);
    }
}

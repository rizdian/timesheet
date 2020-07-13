<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    public function donatur(){
        return $this->belongsTo(Donatur::class);
    }
    public function acara(){
        return $this->belongsTo(Acara::class);
    }
}

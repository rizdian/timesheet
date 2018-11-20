<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function division(){
        return $this->belongsTo(Division::class);
    }
}

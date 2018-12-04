<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function division(){
        return $this->belongsTo(Division::class);
    }

    public function user(){
        return $this->hasOne(User::class);
    }

    public function prf(){
        return $this->hasOne(Prf::class);
    }
}

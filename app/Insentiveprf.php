<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Insentiveprf extends Model
{
    protected $table = 'insentiveprfs';
    public function prfs(){
        return $this->belongsToMany(Prf::class);
    }
}

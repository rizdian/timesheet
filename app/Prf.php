<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prf extends Model
{
    protected $table = 'prfs';

    public function Insentiveprf(){
        return $this->hasMany(insentiveprf::class);
    }

    public function historyApproves()
    {
        return $this->hasMany(HistoryApprove::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryApprove extends Model
{
    public function prf()
    {
        return $this->belongsTo(Prf::class);
    }
}

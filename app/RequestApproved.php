<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestApproved extends Model
{
    //
    public function tdg(){
        return $this->belongsTo(Tdg::class);
    }

    public function agreement(){
        return $this->belongsTo(Agreement::class);
    }
    protected $fillable = [
        'fecha', 'aprobado','tdg_id','agreement_id',
    ];
}

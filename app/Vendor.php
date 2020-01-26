<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'store_id','store_name','address','picture'
    ];

    public function user()
    {
        return $this->belongsTo('App\User','store_id','id');
    }
}

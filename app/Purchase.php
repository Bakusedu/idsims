<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'drug_id','qty','purchasedBy','purchasedfrom'
    ];

    public function drug()
    {
        return $this->belongsTo('App\Drug','drug_id','id');
    }
}

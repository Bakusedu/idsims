<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Drug extends Model
{
    protected $fillable = [
        'name','company','price','effects','interaction','cure','vendor_id','qty','overdose','hcpi',
        'active_ingredients','dosage','drug_type','note','photo','nafdac','expiry_date'
    ];

    protected $table = 'drugs';

    // public function user()
    // {
    //     return $this->belongsTo('App\User');
    // }
}

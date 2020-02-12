<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use App\Drug;
use App\Purchase;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','age','phone','picture','priviledges'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = 'users';
    // relationships

    public function drugs()
    {
        return $this->hasMany('App\Drug','vendor_id');
    }

    public function customerPurchase()
    {
        return $this->hasMany('App\Purchase','purchasedBy');
    }

    public function vendorSoldDrugs()
    {
        return $this->hasMany('App\Purchase','purchasedFrom','id');
    }

    public function vendors()
    {
        return $this->hasOne('App\Vendor','store_id','id');
    }

}

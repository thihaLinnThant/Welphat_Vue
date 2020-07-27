<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'ph_no' , 'address', 'api_token'
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

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function ratings(){
        return $this->hasMany('App\Rating');
    }

    public function wishes(){
        return $this->hasMany('App\Wish');
    }

    public function orders(){
        return $this->hasMany('App\Order');
    }  

    public function admin_notification(){
        return $this->morphMany('App\AdminNotification', 'committer');
    }
}

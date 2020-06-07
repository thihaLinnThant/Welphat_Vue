<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $fillable = ['id', 'user_id', 'phone_no', 'address', 'status' ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function books(){
        return $this->belongsToMany('App\Book', 'book_order');
    }

    public function totalPrice(){
        return $this->books()->sum('price');
    }
    
    public function book_orders(){
        return $this->hasMany('App\Book_order');
    }
}

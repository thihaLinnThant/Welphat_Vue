<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wish extends Model
{
    public $fillable = [ 'id', 'book_id', 'user_id'];

    public function book(){
        return $this->belongsTo('App\Book');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }    
}

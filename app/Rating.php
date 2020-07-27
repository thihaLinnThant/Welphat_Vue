<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    public $fillable = [ 'id', 'rating', 'book_id', 'user_id'];

    public function book(){
        return $this->belongsTo('App\Book');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function admin_activies(){
        return $this->morphMany('App\AdminNotification', 'committed_item');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['id', 'user_id', 'book_id', 'comment_text'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function book(){
        return $this->belongsTo('App\Book');
    }

    public function admin_activies(){
        return $this->morphMany('App\AdminNotification', 'committed_item');
    }
}

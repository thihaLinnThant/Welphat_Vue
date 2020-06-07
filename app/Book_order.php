<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book_order extends Model
{
    protected $table = 'book_order';

    public $fillable = ['id', 'user_id', 'book_id', 'book_name'];

    public function book(){
        return $this->belongsTo('App\Book');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}

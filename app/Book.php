<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public $fillable = [ 'id', 'name', 'description', 'price', 'publisher_id' ];

    public function authors() {
        return $this->belongsToMany('App\Author', 'book_author');
    }

    public function categories() {
        return $this->belongsToMany('App\Category', 'book_category');
    }

    public function tags() {
        return $this->belongsToMany('App\Tag', 'book_tag');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public $fillable = [ 'id', 'name','bio','profile_image' ];

    public function books(){
        return $this->belongsToMany('App\Book', 'book_author');
    }
}

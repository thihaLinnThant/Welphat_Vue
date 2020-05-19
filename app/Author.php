<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public $fillable = [ 'id', 'name' ];

    public function books(){
        return $this->belongsToMany('App\Book', 'book_author');
    }    
}

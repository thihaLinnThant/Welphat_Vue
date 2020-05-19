<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $fillable = [ 'id', 'name' ];

    public function books() {
        return $this->belongsToMany('App\Book', 'book_tag');
    }
}

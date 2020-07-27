<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $fillable = [ 'id', 'name' ];

    public function books() {
        return $this->belongsToMany('App\Book', 'book_category');
    }

    public function admin_activies(){
        return $this->morphMany('App\AdminNotification', 'committed_item');
    }

}

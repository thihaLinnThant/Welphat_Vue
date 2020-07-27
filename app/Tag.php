<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $fillable = [ 'id', 'name' ];

    public function books() {
        return $this->belongsToMany('App\Book', 'book_tag');
    }

    public function admin_activies(){
        return $this->morphMany('App\AdminNotification', 'committed_item');
    }
}

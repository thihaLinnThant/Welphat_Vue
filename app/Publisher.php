<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    public $fillable = [ 'id', 'name' ];

    public function books() {
        return $this->hasMany('App\Book');
    }

    public function admin_activies(){
        return $this->morphMany('App\AdminNotification', 'committed_item');
    }
}

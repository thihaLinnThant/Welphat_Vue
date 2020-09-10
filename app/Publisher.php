<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    public $fillable = [ 'id', 'name', 'phno', 'address', 'email'];

    public function books() {
        return $this->hasMany('App\Book');
    }

    public function admin_activies(){
        return $this->morphMany('App\AdminNotification', 'committed_item');
    }
}

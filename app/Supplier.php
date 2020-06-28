<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    public $fillable = [ 'id', 'name' ,'phno', 'address'];

    public function books() {
        return $this->belongsToMany('App\Book', 'book_supplier');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rating extends Model
{
    public $fillable = [ 'id', 'rating', 'book_id', 'user_id'];
}

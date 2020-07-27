<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public $fillable = [ 'id', 'name', 'description', 'price', 'publisher_id','published_date' ];

    public function authors() {
        return $this->belongsToMany('App\Author', 'book_author');
    }

    public function categories() {
        return $this->belongsToMany('App\Category', 'book_category');
    }

    public function tags() {
        return $this->belongsToMany('App\Tag', 'book_tag');
    }

    public function publisher(){
        return $this->belongsTo('App\Publisher');
    }

    public function suppliers() {
        return $this->belongsToMany('App\Supplier', 'book_supplier');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function ratings(){
        return $this->hasMany('App\Rating');
    }

    public function wishes(){
        return $this->hasMany('App\Wish');
    }

    public function admin_activies(){
        return $this->morphMany('App\AdminNotification', 'committed_item');
    }

    public function damandCount(){
        return $this->wishes()->count();
    }

    public function damandPercent(){
        return $this->wishes()->avg('wish');
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

    public function sumRating()
    {
        return $this->ratings()->sum('rating');
    }

    public function ratingPercent($max = 5)
    {
        $quantity = $this->ratings()->count();
        $total = $this->sumRating();

        return ($quantity * $max) > 0 ? $total / (($quantity * $max) / 100) : 0;
    }
    

    public function orders(){
        return $this->belongsToMany('App\Order', 'book_order');
    }

    public function book_order(){
        return $this->hasMany('App\Book_order');
    }

}

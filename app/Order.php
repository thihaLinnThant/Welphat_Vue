<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $fillable = ['id', 'user_id', 'phone_no', 'address', 'status'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function books()
    {
        return $this->belongsToMany('App\Book', 'book_order');
    }

    public function book_orders()
    {
        return $this->hasMany('App\Book_order');
    }

    public function totalPrice()
    {
        $available_book_price = 0;
        $deleted_book_price = 0;
        $total_book_price = 0;
        foreach ($this->book_orders as $book) {
            $total_book_price += ($book->book_price * $book->qty);
            ($book->book_id)? $available_book_price += ($book->book_price * $book->qty) : $deleted_book_price += ($book->book_price * $book->qty);
        }
        return collect([
               'available_book_price' => $available_book_price,
               'deleted_book_price' => $deleted_book_price,
               'total_book_price' => $total_book_price,
           ]);
    }

    public function count()
    {

      $total_count = $this->book_orders->sum('qty');
      $available_count = 0;
      $deleted_count = 0;

      foreach($this->book_orders as $book){
          ($book->book_id)? $available_count += $book->qty : $deleted_count += $book->qty;
      }
      return collect([
          'available_count' => $available_count,
          'deleted_count' => $deleted_count,
          'total_count' => $total_count,
      ]);

    }
}

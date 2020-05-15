<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_category', function (Blueprint $table) {
            $table->id('id');
            $table->id('book_id');
            $table->id('category_id');
            $table->timestamps();

            $table->primary('id');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('catagory_id')->references('id')->on('catagories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_category');
    }
}

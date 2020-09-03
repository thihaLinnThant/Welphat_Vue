<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPageCountAndBookSizeAndSupplierIdAndLangToBooks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->integer('bookSize')->nullable();
            $table->foreignId('supplier_id')->nullable()->references('id')->on('suppliers')->onDelete('set null');
            $table->string('lang')->nullable()->default("Myanmar");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            //
        });
    }
}

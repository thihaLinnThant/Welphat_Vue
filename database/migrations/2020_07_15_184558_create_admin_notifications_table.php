<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('noti_type');
            $table->nullableMorphs('committer');
            $table->index('committer_id');
            $table->index('committer_type');
            $table->string('message');
            $table->nullableMorphs('committed_item');
            $table->index('committed_item_id');
            $table->index('committed_item_type');
            $table->string('seen_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_notifications');
    }
}

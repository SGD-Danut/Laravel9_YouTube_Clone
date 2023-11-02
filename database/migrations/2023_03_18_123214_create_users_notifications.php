<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_notifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('channel_id');
            $table->bigInteger('video_id');
            $table->bigInteger('comment_id')->nullable();
            $table->bigInteger('reply_id')->nullable();
            $table->bigInteger('video_upload_notify')->nullable();
            $table->bigInteger('video_comment_notify')->nullable();
            $table->bigInteger('comment_reply_notify')->nullable();
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
        Schema::dropIfExists('users_notifications');
    }
};

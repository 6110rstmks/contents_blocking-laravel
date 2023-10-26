<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_youtube_channel', function (Blueprint $table) {
            $table->primary(['user_id', 'youtube_channel_id']);
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('youtube_channel_id')->unsigned();

            $table->foreign('user_id', 'youtube_userTable_userId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('youtube_channel_id', 'youtube_userTable_youtubeId')->references('id')->on('youtube_channels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_youtube_channel');
    }
};

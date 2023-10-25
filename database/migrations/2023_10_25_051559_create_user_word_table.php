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
        Schema::create('user_word', function (Blueprint $table) {
            $table->primary(['user_id', 'word_id']);
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('word_id')->unsigned();

            $table->foreign('user_id', 'word_userTable_userId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('word_id', 'word_userTable_wordId')->references('id')->on('words')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_word');
    }
};

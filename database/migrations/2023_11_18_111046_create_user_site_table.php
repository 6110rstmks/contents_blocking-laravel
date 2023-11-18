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
        Schema::create('user_site', function (Blueprint $table) {
            $table->primary(['user_id', 'site_id']);
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('site_id')->unsigned();

            $table->foreign('user_id', 'site_userTable_userId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('site_id', 'site_userTable_siteId')->references('id')->on('sites')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_sites');
    }
};

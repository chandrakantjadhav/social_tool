<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FeedPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feed_post', function (Blueprint $table) {
            //
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->integer('likes');
            $table->string('desc');
            $table->string('caption');
            $table->string('image');
            $table->string('thumbnail');

            //index for foreign keys
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feed_post', function (Blueprint $table) {
            //
        });
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('venue_id');
            $table->string('event_name',30);
            $table->string('title',30);
            $table->string('description',1000)->nullable();
            $table->string('event_type',30);
            $table->string('dree_code',30);
            $table->string('music_type',30);
            $table->string('price',30)->nullable();
            $table->string('date_from');
            $table->string('date_to');
            $table->string('time_from');
            $table->string('time_to');
            $table->string('age_restriction');
            $table->string('parking');
            $table->string('phone',15)->nullable();
            $table->string('facebook_url',255);
            $table->string('twitter_url',255);
            $table->string('youtube_url',255);
            $table->string('recurring');
            $table->string('photo');

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
        Schema::drop('event');
    }
}

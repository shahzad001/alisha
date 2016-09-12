<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('venue_name',30);
            $table->string('venue_address',255);
            $table->string('description',255);
            $table->string('city',30);
            $table->string('state',30)->nullable();
            $table->string('postal_code',30)->nullable();
            $table->string('venue_phone',15)->nullable();
            $table->string('venue_website',30)->nullable();
            $table->string('venue_email')->nullable();
            $table->string('time_from');
            $table->string('time_to');
            $table->enum('days_closed',['Saturday','Sunday'])->default(null);
            $table->string('photo');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('venues');
    }
}

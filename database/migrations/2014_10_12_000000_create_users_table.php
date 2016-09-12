<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('staff_name',255);
            $table->string('staff_phone',255);
            $table->string('first_name',30)->nullable();
            $table->string('last_name',30)->nullable();
            $table->string('phone_number',15)->nullable();
            $table->string('email_address')->unique();
            $table->string('password', 60);
            $table->integer('facebook_id');
            $table->enum('user_type',['user','venue_owner','staff','admin'])->default(null);
            $table->rememberToken();

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
        Schema::drop('users');
    }
}

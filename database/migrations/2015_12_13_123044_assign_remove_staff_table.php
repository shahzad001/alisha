<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AssignRemoveStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_remove_staff', function (Blueprint $table) {
            $table->increments('id');
            $table->string('staff_name',255)->nullable();
            $table->string('venue_name',30)->nullable();
            $table->string('event_name',30)->nullable();
            $table->string('staff_role',30)->nullable();
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
        Schema::drop('assign_remove_staff');
    }
}

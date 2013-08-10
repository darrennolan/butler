<?php

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
        Schema::create('users', function($table) {
            $table->increments('id')->unsigned();
            $table->string('email');
            $table->string('password');

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('display_name')->nullable();

            $table->string('url')->nullable();

            $table->enum('status', array('active', 'pending', 'trash', 'disabled'))->default('active');

            $table->timestamps();

            $table->unique('email');                // User emails are unique
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropUnique('users_email_unique');
        });
        Schema::drop('users');
    }

}

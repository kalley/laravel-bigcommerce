<?php

use Illuminate\Database\Migrations\Migration;

class AddBigcommerceToUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Alters the users table
        Schema::table('users', function ($table) {
      		$table->integer('bigcommerce_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function($table) {
        		$table->dropColumn(['bigcommerce_id']);
    		});
    }
}

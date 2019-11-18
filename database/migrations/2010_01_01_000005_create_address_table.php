<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAddressTable extends Migration {

	public function up()
	{
		Schema::create('address', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('address_1', 255);
			$table->string('address_2', 255)->nullable();
			$table->string('city');
			$table->string('country');
			$table->enum('type', array('billing', 'delivery'));
			$table->string('zipcode');
			$table->bigInteger('user_id')->unsigned();
		});

		Schema::table('address', function($table) {
			$table->foreign('user_id')->references('id')->on('users');
		});
	}

	public function down()
	{
		Schema::drop('address');
	}
}
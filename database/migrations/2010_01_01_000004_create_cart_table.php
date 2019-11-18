<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCartTable extends Migration {

	public function up()
	{
		Schema::create('cart', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->double('cumul_price');
			$table->bigInteger('user_id')->unsigned();
		});

		Schema::table('cart', function($table) {
			$table->foreign('user_id')->references('id')->on('users');
		});
	}

	public function down()
	{
		Schema::drop('cart');
	}
}
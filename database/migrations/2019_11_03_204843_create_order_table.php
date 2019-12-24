<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderTable extends Migration {

	public function up()
	{
		Schema::create('order', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('order');
	}
}
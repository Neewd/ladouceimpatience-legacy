<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductTable extends Migration {

	public function up()
	{
		Schema::create('product', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->string('name');
			$table->string('description');
			$table->bigInteger('brand_id')->unsigned();
			$table->integer('available_stock')->default('0');
			$table->integer('range');
		});

		Schema::table('product', function($table) {
			$table->foreign('brand_id')->references('id')->on('brand');
		});
	}

	public function down()
	{
		Schema::drop('product');
	}
}
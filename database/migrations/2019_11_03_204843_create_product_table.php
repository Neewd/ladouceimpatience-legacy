<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductTable extends Migration {

	public function up()
	{
		Schema::create('product', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('thumbnail_url');
			$table->string('picture_url');
			$table->string('description');
			$table->string('brand');
			$table->integer('available_stock')->default('0');
			$table->double('unit_price');
		});
	}

	public function down()
	{
		Schema::drop('product');
	}
}
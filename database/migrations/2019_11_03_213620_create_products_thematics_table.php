<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsThematicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_thematics', function(Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('order');
            $table->integer('thematic_id')->unsigned();
            $table->integer('product_id')->unsigned();
        });

        Schema::table('products_thematics', function($table) {            
            $table->foreign('thematic_id')->references('id')->on('thematic');
            $table->foreign('product_id')->references('id')->on('product');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products_thematics');
    }
}

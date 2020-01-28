<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_labels', function(Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->bigInteger('label_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
        });

        Schema::table('products_labels', function($table) {            
            $table->foreign('label_id')->references('id')->on('label');
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
        Schema::dropIfExists('products_labels');
    }
}

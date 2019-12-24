<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('products_images', function(Blueprint $table) {
        $table->increments('id');
        $table->timestamps();
        $table->string('type');
        $table->string('picture_url');
        $table->bigInteger('product_id')->unsigned();
      });

      Schema::table('products_images', function($table) {
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
        Schema::dropIfExists('products_images');
    }
}

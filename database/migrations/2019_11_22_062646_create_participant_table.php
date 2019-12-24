<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participant', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email');
            $table->string('firstname');
            $table->string('lastname');
            $table->date('birth_date');
            $table->integer('list_id');
            $table->string('unsubscribe_token');
            $table->bigInteger('unsubscribe_reason_id')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::table('participant', function($table) {            
            $table->foreign('unsubscribe_reason_id')->references('id')->on('unsubscribe_reasons');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participant');
    }
}

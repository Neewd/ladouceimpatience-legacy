<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsletterParticipantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletter_participant', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status');
            $table->bigInteger('participant_id')->unsigned();
            $table->bigInteger('newsletter_id')->unsigned();
            $table->foreign('participant_id')->references('id')->on('participant')->onDelete('cascade');
            $table->foreign('newsletter_id')->references('id')->on('newsletter')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('newsletter_participant');
    }
}

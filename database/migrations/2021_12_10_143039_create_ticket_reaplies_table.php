<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketReapliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_reaplies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ticket_id')->unsigned();
            $table->enum('user_type',['user','admin']);
            $table->string('document')->nullable();
            $table->longText('message');
            $table->foreign('ticket_id')
                  ->references('id')
                  ->on('user_tickets')
                  ->onDelete('cascade');
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
        Schema::dropIfExists('ticket_reaplies');
    }
}

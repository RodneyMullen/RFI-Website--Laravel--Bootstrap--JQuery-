<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Referee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referees',function(Blueprint $table){
            
            $table->integer('member'); // will be used as foreign key to membership table memember no
            $table->foreign('member')->references('membership_no')->on('members_table'); //foregin key to membership table member no
            $table->integer('referrer'); // will be used as foreign key to membership table memember no
            $table->foreign('referrer')->references('membership_no')->on('members_table'); //foregin key to membership table member no
            $table->datetime('created_at'); // date the page was created
            $table->datetime('updated_at'); // date the page was updated
            $table->increments('id'); // id of recrod
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referees');
    }
}

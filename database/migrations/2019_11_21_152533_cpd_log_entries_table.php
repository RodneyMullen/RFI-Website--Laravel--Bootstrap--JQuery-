<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CpdLogEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpd_activities_table',function(Blueprint $table){
            
            $table->integer('member'); // will be used as foreign key to membership table memember no
            $table->foreign('member')->references('membership_no')->on('members_table'); //foregin key to membership table member no
            $table->string('activity_name'); // will be used as activity type
            $table->foreign('activity_name')->references('activity_name')->on('cpd_activities_table'); //foreign key to cpd activity table  
            $table->date('start_date'); // date the activity was started
            $table->date('end_date'); // date the activity ended
            $table->integer('hours'); //number of hours
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpd_activities_table');
    }
}

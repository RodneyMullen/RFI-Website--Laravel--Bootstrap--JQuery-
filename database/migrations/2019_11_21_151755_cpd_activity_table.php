<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CpdActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpd_activities_table',function(Blueprint $table){
            
            $table->string('cpd_activity_type'); // will be used as activity type
            $table->foreign('cpd_activity_type')->references('cpd_activity_type')->on('cpd_activities_types_table'); //foreign key to activities type table  
            $table->string('cpd_activity_band'); // will be used as activity type
            $table->foreign('cpd_activity_band')->references('cpd_activity_band')->on('cpd_activities_bands_table'); //foreign key to activities bands table  
            $table->string('activity_name')->unique(); // name of activity
            $table->integer('points'); //points awarded
            $table->longText('description')->nullable(); //description of activity
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
        Schema::dropIfExists('cpd_activities_table');
    }
}

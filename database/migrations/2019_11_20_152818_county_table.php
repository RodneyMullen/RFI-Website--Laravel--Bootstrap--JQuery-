<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CountyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('county_table',function(Blueprint $table){
            
            
            $table->string('county')->unique(); // type of listing
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
        Schema::dropIfExists('county_table');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MembershipTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membership_types',function(Blueprint $table){
            
            
            $table->string('membership_type')->unique(); // type of membership
            $table->longText('description')->nullable(); // description
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
        Schema::dropIfExists('membership_types');
    }
}

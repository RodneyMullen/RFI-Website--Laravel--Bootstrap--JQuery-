<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PractitionerListingLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practitioner_listing_locations_table',function(Blueprint $table){
            
            $table->integer('listing_name'); // will be used as foreign key to membership table memember no
            $table->foreign('listing_name')->references('listing_name')->on('practitioner_listings_table'); //foregin key to listing name
            $table->string('address_one'); // line one of address
            $table->string('address_two'); // line two of address
            $table->string('address_three'); // line three of address
            $table->string('county'); // line three of address
            $table->foreign('county')->references('county')->on('county_table'); //foregin key to county table
            $table->string('postcode')->nullable(); // postcode
            $table->string('gps')->nullable(); // gps
            $table->longText('description')->nullable(); // description of insurance provider
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
        Schema::dropIfExists('practitioner_listing_locations_table');
    }
}

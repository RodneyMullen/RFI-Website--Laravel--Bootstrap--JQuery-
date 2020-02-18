<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PractitionerListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practitioner_listings',function(Blueprint $table){
            
            $table->integer('member'); // will be used as foreign key to membership table memember no
            $table->foreign('member')->references('membership_no')->on('members_table'); //foregin key to membership table member no
            $table->string('listing_preference'); // will be used as foreign key to membership table memember no
            $table->foreign('listing_preference')->references('listing_preference')->on('membership_listing_preferencce_table'); //foregin key to membership table member no
            $table->string('appear_on_website'); // 0 for no 1 for yes
            $table->string('listing_name')->unique(); // name of listing
            $table->string('phone')->nullable(); // phone
            $table->string('mobile')->nullable(); // mobile
            $table->string('email')->nullable(); // email
            $table->string('listing_website')->nullable(); // website of listing
            $table->string('is_exempt'); // 0 for no 1 for yes
            $table->longText('listing_notes')->nullable(); // notes on the listing
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
        Schema::dropIfExists('practitioner_listings');
    }
}

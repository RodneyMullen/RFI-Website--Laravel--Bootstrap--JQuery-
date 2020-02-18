<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebpageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webpages',function(Blueprint $table){
            $table->increments('id'); // unique ID for the webpage, primary key
            $table->string('webpage_name')->unique(); //name used to call the webpage
            $table->text('seo_words')->nullable(); // SEO words for the page's meta tags, can be null
            $table->text('description')->nullable(); // description of the website
            $table->string('webpage_title')->unique(); // title for the page
            $table->boolean('status')->default(0);// status of the page, 0 for inactive, 1 for active
            $table->longText('content')->nullable(); // Summernote content ID for the page, can be null
            $table->json('child_collection')->nullable(); // A JSON of the page's children and order i.e. 1, Pagename. can be null
            $table->json('webpage_extras')->nullable(); // A JSON of the webpage extras available, can be null
            $table->string('parent'); // name of the parent, taken from current list of webpages
            $table->datetime('created_at'); // date the page was created
            $table->datetime('updated_at'); // date the page was updated
             
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('webpages');
    }
}

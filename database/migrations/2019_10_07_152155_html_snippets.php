<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HtmlSnippets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('html_snippets',function(Blueprint $table){
            $table->increments('id'); // id of recrod
            $table->string('type')->unique(); // type of record
            $table->longText('content')->nullable(); // content of the html snippet
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
        Schema::dropIfExists('html_snippets');
    }
}

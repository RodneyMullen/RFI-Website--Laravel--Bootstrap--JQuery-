<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RfiMembershipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfi_memberships',function(Blueprint $table){
            
            $table->integer('member'); // will be used as foreign key to membership table memember no
            $table->foreign('member')->references('membership_no')->on('members_table'); //foregin key to membership table member no
            $table->string('membership_type'); // will be used as foreign key to membership table memember no
            $table->foreign('membership_type')->references('membership_type')->on('membership_type_table'); //foregin key to membership type table member no
            $table->longText('notes')->nullable(); // notes
            $table->date('start_of_membership'); // date the page was created
            $table->date('end_of_membership'); // date the page was updated
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
        Schema::dropIfExists('rfi_memberships');
    }
}

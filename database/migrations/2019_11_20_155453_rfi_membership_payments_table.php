<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RfiMembershipPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfi_membership_payments_table',function(Blueprint $table){
            
            $table->integer('member'); // will be used as foreign key to membership table memember no
            $table->foreign('member')->references('membership_no')->on('members_table'); //foregin key to membership table member no
            $table->string('payment_type'); // will be used as foreign key to membership table memember no
            $table->foreign('payment_type')->references('payment_type')->on('payment_type_table'); //foregin key to membership table member no
            $table->date('Date'); // date of payment
            $table->integer('amount'); // amount paid
            $table->longText('notes')->nullable();
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
        Schema::dropIfExists('rfi_membership_payments_table');
    }
}

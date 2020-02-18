<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PractitionerInsuranceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practitioner_insurances',function(Blueprint $table){
            $table->increments('id'); // id of recrod
            $table->integer('member'); // will be used as foreign key to membership table memember no
            $table->foreign('member')->references('membership_no')->on('members_table'); //foregin key to membership table member no
            $table->string('insurance_type'); // will be used as foreign key to certificate in cert type table
            $table->foreign('insurance_type')->references('insurance_type')->on('insurance_types');
            $table->string('insurance_provider_name'); // will be used as foreign key to certificate in cert type table
            $table->foreign('insurance_provider_name')->references('insurance_provider_name')->on('insurance_providers');
            $table->date('start_date'); // start date of insurance
            $table->date('end_date'); // start date of insurance
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
        Schema::dropIfExists('practitioner_insurances');
    }
}

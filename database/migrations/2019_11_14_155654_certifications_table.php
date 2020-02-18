<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CertificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('certifications',function(Blueprint $table){
            $table->increments('id'); // id of recrod
            $table->integer('member'); // will be used as foreign key to membership table memember no
            $table->foreign('member')->references('membership_no')->on('members_table'); //foregin key to membership table member no
            $table->string('certificate'); // will be used as foreign key to certificate in cert type table
            $table->foreign('certificate')->references('certification')->on('cert_types');
            $table->string('teacher')->nullable(); // teacher of cert
            $table->integer('number_of_days_of_training')->nullable(); // number of days of training
            $table->date('date_of_cert'); // date of the cert was created
            $table->date('date_expires')->nullable(); // date the cert expires
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
        Schema::dropIfExists('certifications');
    }
}

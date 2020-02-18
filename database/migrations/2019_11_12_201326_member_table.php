<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members',function(Blueprint $table){
            
            
            $table->integer('membership_no')->unique(); // id of recrod
            $table->string('name'); // name of member
            $table->string('surname'); // name of member
            $table->longText('address_line_one'); // address line 1
            $table->longText('address_line_two')->nullable(); // address line 2
            $table->longText('address_line_three')->nullable(); // address line 3
            $table->string('county'); // address count
            $table->string('address_country'); // address country
            $table->string('post_code')->nullable(); // post code
            $table->string('email')->nullable(); // email
            $table->string('mobile')->nullable(); // mobile
            $table->string('home_phone')->nullable(); // home phone
            $table->string('work_phone')->nullable(); // work phone
            $table->string('occupation')->nullable(); // mobile
            $table->string('gender'); // gender, o for female, 1 to male
            $table->longText('skills')->nullable(); // skills
            $table->date('date_of_birth'); // date of birth
            $table->string('profile'); // administrator, standard user etc
            $table->longText('notes')->nullable();  // notes on the member
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
        Schema::dropIfExists('members');
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthenticaionTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
   
    
  public function test_create_new_user()
  {
      $this->get('/')
              ->click('Register')
               ->seePageIs('/register');
  }
    
    
    /*
    public function test_it_creates_a_new_contact() 
    { 
        $user = factory( User::class)-> create(); 
        $this-> be($user); 
        $this-> post('users', [ 'name' => 'Mr Example', 'email'=>'my@email.com' ]); 
        $this-> assertDatabaseHas('users', [ 'name' => 'Mr Example','email' => 'my@email.com', 'id' => $user-> id, ]); 
        
    }*/
    /*
    public function test_it_creates_a_new_user() 
    { 
       
        $response = $this->get('/');
        
        
        $user = factory( User::class)-> create(); 
        $this-> be($user); 
        $response=$this-> post('users', [ 'name' => 'Mr Example', 'email'=>'my@email.com' ]); 
        $response->assertRedirect('/webpageadmin');
        $this-> assertDatabaseHas('users', [ 'name' => 'Mr Example','email' => 'my@email.com', 'id' => $user-> id, ]); 
        
    }*/
    /*
    public function test_users_can_register() 
    { 
        $response= $this-> post('register', ['name' => 'Sal Leibowitz', 
                                    'email' => 'sal@leibs.net', 
                                    'password' => 'abcdefg123', 
                                    'password_confirmation' => 'abcdefg123', ]); 
         
        $response->assertRedirect('/webpageadmin');
        $this-> assertDatabaseHas('users', [ 'name' => 'Sal Leibowitz', 
                                            'email' => 'sal@leibs.net', ]); 
        
    }*/
    /*
    public function test_users_can_log_in() 
    { 
        $user = factory( User::class)-> create([ 'password' => bcrypt('abcdefg123') ]);
        $response2 = $this-> post('login', [ 'email' => $user-> email, 'password' => 'abcdefg123', ]); 
        $response2->assertRedirect('/webpageadmin');
        $this-> assertTrue( auth()-> check()); 
        $this->assertAuthenticated($guard = null);
        $text = array('Website Administration', 'Add Webpage', 'Edit Webpage', 'Edit Header', 'Edit Footer', 'Website Administration', 'Please choose a seletion on the left panel');
        $response= $this->get('/webpageadmin');
        $response->assertSeeInOrder($text);
    }*/
 

}

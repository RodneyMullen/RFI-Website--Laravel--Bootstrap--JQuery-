<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Chrome;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_LoginUser()
    {
        
        $user = factory(User::class)->create([
            'email' => 'test3@test.com',
        ]);

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'secret')
                    ->press('Login')
                    ->assertPathIs('/rfi-uat/public//login');
        });
        
        $this->assertDatabaseHas('users', [
            'email' => 'test3@test.com']);
    
    }
    
    
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvalidPageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    
    public function testInvalidPageView()
    {
        $text = array('Opps!! Something happened', 'The page you are searching for does not exist.  Please try again');
        $response= $this->get('/');
        $response->assertSeeInOrder($text);
        
    }
}

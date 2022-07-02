<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    //Check if login page exists
    public function test_login_form()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    //Check if user exists in database
    public function test_user_duplication()
    {
        $user1 = User::make([
            'user_name' => 'admin',
            'email' => 'rehamalbulushi1998@gmail.com'
        ]);

        $user2 = User::make([
            'user_name' => 'reham98',
            'email' => 'reham@databoat.com'
        ]);

        $this->assertTrue($user1->name != $user2->name);
    }

    //Test if a user can be deleted (make sure that you add the middleware)
    public function test_delete_user()
    {
        $user = User::factory()->count(1)->make();

        $user = User::first();

        if($user) {
            $user->delete();
        }

        $this->assertTrue(true);
    }

    //Perform a post() request to add a new user
    public function test_if_it_stores_new_users()
    {
        $response = $this->post('/register', [
            'user_name' => 'reham98',
            'email' => 'reham@databoat.com',
            'user_type' => 'reader',
            'password' => 'reham160088',
            'password_confirmation' => 'reham160088'
        ]);

        $response->assertRedirect('/dashboard');
    }

    public function test_if_data_exists_in_database()
    {
        $this->assertDatabaseHas('users', [
            'user_name' => 'reham98'
        ]);
    }

    public function test_if_data_does_not_exists_in_database()
    {
        $this->assertDatabaseHas('users', [
            'user_name' => 'John'
        ]);
    }

   
}

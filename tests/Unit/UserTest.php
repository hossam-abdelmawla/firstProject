<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_login_form()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_user_duplication()
    {
        $user1 = User::make([
            'name'  => 'hossam',
            'email' => 'hossam@gmail.com'
        ]);
        $user2 = User::make([
            'name'  => 'seven',
            'email' => 'seven@gmail.com'
        ]);

        $this->assertTrue($user1->name != $user2->name);
    }
    public function test_delete_user()
    {
        $user = User::factory()->count(1)->make();
        $user = User::first();
        if ($user) {
            $user->delete();
        }
        $this->assertTrue(true);
    }
    public function test_it_stores_new_users()
    {
        $response = $this->post('/register', [
            'name'                  => 'hossseven',
            'email'                 => 'hossseven@gmail.com',
            'password'              => '123456',
            'password_confirmation' => '123456'

        ]);
        $response->assertRedirect('/');
    }
}

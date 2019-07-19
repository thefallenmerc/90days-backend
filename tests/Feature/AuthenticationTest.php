<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthenticationTest extends TestCase
{

    public function test_if_user_can_register()
    {
        // get user data
        $user = make('App\User')->toArray();
        $user["password"] = 'password';
        // hit register with the data
        $response = $this->post('/api/register', $user, generateAPIHeaders());
        // check json response
        $response->assertJson(['success' => ['name' => $user['name']]]);
        // check response status
        $response->assertStatus(201);
        return $response->json();
    }

    public function test_if_user_can_login()
    {
        // create user
        $user = create('App\User');
        // hit login with user's credentials
        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password'
        ], generateAPIHeaders());
        // check response json
        $response->assertJsonStructure(['success' => [
            'token'
        ]]);
        // check response status   
        $response->assertStatus(200);
    }

    public function test_if_a_user_can_see_their_details()
    {
        // create user
        $user = create('App\User');
        // hit the detail endpoint
        $response = $this->get('/api/user/detail', generateAPIHeaders($user));
        // check the response json
        $response->assertJson(['success' => $user->toArray()]);
        // check the respose status
        $response->assertStatus(200);
    }
}

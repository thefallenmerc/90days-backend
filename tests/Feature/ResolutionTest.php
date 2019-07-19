<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResolutionTest extends TestCase
{
    public function test_if_an_authenticated_user_can_create_a_resolution()
    {
        // create user
        $user = create('App\User');
        // make resolution data
        $data = make('App\Resolution', ['user_id' => $user->id]);
        // hit create resolution endpoint with resolution data
        $response = $this->post('api/resolutions', $data->toArray(), generateAPIHeaders($user));
        // check response json
        $response->assertJsonFragment($data->toArray());
        // check respons status
        $response->assertStatus(201);
    }

    public function test_if_an_authenticated_user_can_view_their_resolution()
    {
        // create user
        $user = create('App\User');
        // make resolution list
        $resolutions = create('App\Resolution', ['user_id' => $user->id], 10);
        // hit list resolution endpoint
        $response = $this->get('/api/resolutions', generateAPIHeaders($user));
        // check response data
        $response->assertJson(['success' => $resolutions->toArray()]);
        // check response status
        $response->assertStatus(200);
    }

    public function test_if_an_authenticated_user_can_edit_their_resolution()
    {
        // create user
        $user = create('App\User');
        // add resolution
        $resolution = create('App\Resolution', ['user_id' => $user->id]);
        $changes = ['title' => 'New Title'];
        // hit edit resolution endpoint
        $response = $this->put('/api/resolutions/' . $resolution->id, $changes, generateAPIHeaders($user));
        // check response data
        $response->assertJsonFragment($changes);
        // check response status
        $response->assertStatus(200);
    }

    public function test_if_an_authenticated_user_can_delete_their_resolution()
    {
        // create user
        $user = create('App\User');
        // create resolution
        $resolution = create('App\Resolution', ['user_id' => $user->id]);
        // hit the delete resolution endpoint
        $response = $this->delete('/api/resolutions/' . $resolution->id, [], generateAPIHeaders($user));
        // check response data
        $response->assertJsonStructure(['success' => []]);
        // check response status
        $response->assertStatus(200);
    }
}

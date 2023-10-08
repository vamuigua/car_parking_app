<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanGetTheirProfile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/v1/profile');

        $response->assertStatus(200)
            ->assertJsonStructure(['name', 'email'])
            ->assertJsonCount(2)
            ->assertJsonFragment(['name' => $user->name]);
    }

    public function testUnauthenticatedUserCannotAccessProfileData()
    {
        $response = $this->getJson('/api/v1/profile');

        $response->assertUnauthorized()
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    public function testUserCanUpdateNameAndEmail()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/profile', [
            'name'  => 'John Updated',
            'email' => 'john_updated@example.com',
        ]);

        $response->assertStatus(202)
            ->assertJsonStructure(['name', 'email'])
            ->assertJsonCount(2)
            ->assertJsonFragment(['name' => 'John Updated']);

        $this->assertDatabaseHas('users', [
            'name'  => 'John Updated',
            'email' => 'john_updated@example.com',
        ]);
    }

    public function testUserCannotUpdateNameAndEmailWithInvalidData()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/profile', [
            'name'  => '',
            'email' => '',
        ]);

        $response->assertUnprocessable()
            ->assertInvalid(['name', 'email']);
    }

    public function testUserCanChangePassword()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/password', [
            'current_password'      => 'password',
            'password'              => 'testing123',
            'password_confirmation' => 'testing123',
        ]);

        $response->assertStatus(202);
    }

    public function testUnauthenticatedUserCannotUpdatePassword()
    {
        $response = $this->putJson('/api/v1/password', [
            'current_password'      => 'password',
            'password'              => 'testingpassword123',
            'password_confirmation' => 'testingpassword123',
        ]);

        $response->assertUnauthorized()
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }

    public function testUserCannotUpdatePasswordWithNonMatchingPassword()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/password', [
            'current_password'      => 'password',
            'password'              => 'my_new_password',
            'password_confirmation' => 'wrong_confirm_password',
        ]);

        $response->assertUnprocessable()
            ->assertInvalid([
                'password' => 'The password field confirmation does not match.'
            ]);
    }
}

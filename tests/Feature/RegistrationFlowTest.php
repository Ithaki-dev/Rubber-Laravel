<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegistrationFlowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_register_as_driver()
    {
        Mail::fake();

        $response = $this->post('/register', [
            'name' => 'John',
            'surname' => 'Doe',
            'cedula' => '123456789',
            'birthdate' => '1990-01-01',
            'email' => 'john@example.com',
            'phone' => '88888888',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'driver',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'role' => 'driver',
            'status' => 'pending',
        ]);

        Mail::assertSent(\App\Mail\AccountActivation::class);
    }

    /** @test */
    public function user_can_register_as_passenger()
    {
        Mail::fake();

        $response = $this->post('/register', [
            'name' => 'Jane',
            'surname' => 'Smith',
            'cedula' => '987654321',
            'birthdate' => '1992-05-15',
            'email' => 'jane@example.com',
            'phone' => '77777777',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'passenger',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'jane@example.com',
            'role' => 'passenger',
            'status' => 'pending',
        ]);
    }

    /** @test */
    public function pending_user_cannot_login()
    {
        $user = User::factory()->create([
            'email' => 'pending@example.com',
            'password' => 'password123',
            'status' => 'pending',
        ]);

        $response = $this->post('/login', [
            'email' => 'pending@example.com',
            'password' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function active_user_can_login()
    {
        $user = User::factory()->create([
            'email' => 'active@example.com',
            'password' => 'password123',
            'status' => 'active',
        ]);

        $response = $this->post('/login', [
            'email' => 'active@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function inactive_user_cannot_login()
    {
        $user = User::factory()->create([
            'email' => 'inactive@example.com',
            'password' => 'password123',
            'status' => 'inactive',
        ]);

        $response = $this->post('/login', [
            'email' => 'inactive@example.com',
            'password' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }
}

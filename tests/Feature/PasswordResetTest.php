<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use DatabaseTransactions;

    public function test_forgot_password_page_loads(): void
    {
        $response = $this->get('/forgot-password');
        $response->assertStatus(200);
    }

    public function test_forgot_password_validates_email_format(): void
    {
        // Must use .ac.id
        $response = $this->postJson('/api/v1/forgot-password', [
            'email' => 'invalid-email@gmail.com',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_forgot_password_checks_if_email_exists(): void
    {
        $response = $this->postJson('/api/v1/forgot-password', [
            'email' => 'nonexistent@mhs.unsoed.ac.id',
        ]);

        $response->assertStatus(422);
    }

    public function test_forgot_password_generates_otp_successfully(): void
    {
        $user = User::factory()->create([
            'email' => 'student@mhs.unsoed.ac.id',
            'no_kampus' => 'H1D024001',
        ]);

        $response = $this->postJson('/api/v1/forgot-password', [
            'email' => 'student@mhs.unsoed.ac.id',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['message', 'demo_otp']);

        $user->refresh();
        $this->assertNotNull($user->verification_token);
        $this->assertNotNull($user->token_expired_at);
    }

    public function test_reset_password_succeeds_with_correct_otp(): void
    {
        $user = User::factory()->create([
            'email' => 'student@mhs.unsoed.ac.id',
            'no_kampus' => 'H1D024001',
            'password' => Hash::make('oldpassword'),
            'verification_token' => '123456',
            'token_expired_at' => now()->addMinutes(15),
        ]);

        $response = $this->postJson('/api/v1/reset-password', [
            'email' => 'student@mhs.unsoed.ac.id',
            'otp' => '123456',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertStatus(200);

        $user->refresh();
        $this->assertTrue(Hash::check('newpassword123', $user->password));
        $this->assertNull($user->verification_token);
        $this->assertNull($user->token_expired_at);
    }
}

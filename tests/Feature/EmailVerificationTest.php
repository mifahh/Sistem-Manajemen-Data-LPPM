<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user can register with email verification
     */
    public function test_user_can_register_and_receive_verification_email()
    {
        $response = $this->post('/register', [
            'id' => '2594001',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'no_hp' => '081234567890',
            'role' => '2',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'email_verified_at' => null, // Email belum diverifikasi
        ]);

        $response->assertRedirect(route('menulogin'));
    }

    /**
     * Test unverified user cannot access dashboard
     */
    public function test_unverified_user_cannot_access_dashboard()
    {
        $user = User::factory()->create([
            'email_verified_at' => null, // Email belum diverifikasi
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertRedirect(route('verification.notice'));
    }

    /**
     * Test user can verify email
     */
    public function test_user_can_verify_email()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        // Generate verification URL
        $verificationUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'verification.verify',
            \Illuminate\Support\Carbon::now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $user->refresh();
        $this->assertNotNull($user->email_verified_at);
    }

    /**
     * Test user can resend verification email
     */
    public function test_user_can_resend_verification_email()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)->post(route('verification.resend'));

        $response->assertSessionHas('alert-success');
    }

    /**
     * Test user can request password reset
     */
    public function test_user_can_request_password_reset()
    {
        $user = User::factory()->create();

        $response = $this->post(route('password.email'), [
            'email' => $user->email,
        ]);

        $response->assertSessionHas('alert-success');

        // Check if reset token created
        $this->assertTrue(
            DB::table('password_reset_tokens')
                ->where('email', $user->email)
                ->exists()
        );
    }

    /**
     * Test user can reset password
     */
    public function test_user_can_reset_password()
    {
        $user = User::factory()->create();

        // Create password reset token
        $token = \Illuminate\Support\Facades\Password::createToken($user);

        $response = $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect(route('menulogin'));

        // Verify password changed
        $user->refresh();
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('newpassword123', $user->password));
    }

    /**
     * Test invalid reset token is rejected
     */
    public function test_invalid_reset_token_is_rejected()
    {
        $user = User::factory()->create();

        $response = $this->post(route('password.update'), [
            'token' => 'invalid-token',
            'email' => $user->email,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertSessionHas('alert-danger');
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;  // ✅ RefreshDatabase works with MySQL too!

    // ✅ Runs before each test - migrates fresh
    protected function setUp(): void
    {
        parent::setUp();

        // Optional: Disable foreign key checks for speed
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
    }

    // ============================================
    // TEST: User Registration
    // ============================================
    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'data' => ['user', 'token']
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@test.com'
        ]);
    }

    // ============================================
    // TEST: User Login
    // ============================================
    public function test_user_can_login()
    {
        // Create user
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@test.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => ['token']
            ]);
    }

    // ============================================
    // TEST: Invalid Login
    // ============================================
    public function test_user_cannot_login_with_wrong_password()
    {
        User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@test.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid credentials'
            ]);
    }

    // ============================================
    // TEST: Protected Route
    // ============================================
    public function test_protected_route_requires_token()
    {
        $response = $this->getJson('/api/user');
        $response->assertStatus(401);
    }
}

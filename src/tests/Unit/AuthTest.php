<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

use function Illuminate\Support\now;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        User::factory()->create([
            'username' => 'testuser',
            'password' => bcrypt('password123')
        ]);
    }

    public function login_correct_token()
    {
        $respone = $this->postJson('/api/login', [
            'username' => 'testuser',
            'password' => 'password123'
        ]);

        $respone->assertStatus(200)->assertJsonStructure([
            'token',
            'exp'
        ]);
    }

    public function login_wrong_fails()
    {
        $respone = $this->postJson('/api/login', [
            'username' => 'testuser',
            'password' => 'wrongpassword'
        ]);

        $respone->assertStatus(401)->assertJson([
            'message' => 'Username dan Password anda salah'
        ]);
    }

    public function login_blocks_many_attempts()
    {
        $ip = '127.0.0.1';
        $cacheKey = 'login_attempts:' . $ip;

        Cache::put($cacheKey, 5, now()->addMinutes(5));

        $respone = $this->withServerVariables(['REMOTE_ADDR' => $ip])
            ->postJson('/api/login', [
                'username' => 'testuser',
                'password' => 'wrongpassword'
            ]);

        $respone->assertStatus(429)->assertJson([
            'message' => 'Login gagal, coba lagi'
        ]);
    }

    public function logout_deleted_token()
    {
        $user = User::first();
        Sanctum::actingAs($user, [], 'web');

        $respone = $this->postJson('/api/logout');
        $respone->assertStatus(200)->assertJson([
            'message' => 'Berhasil Logout'
        ]);
    }
}

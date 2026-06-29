<?php

namespace Modules\Dashboard\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\App\Models\User;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticated_users_accessing_admin_are_redirected_to_admin_login()
    {
        $response = $this->get('/admin');

        $response->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function non_admin_users_accessing_admin_are_redirected_to_admin_login()
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_users_can_access_admin_dashboard()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }

    /** @test */
    public function dashboard_route_redirects_admin_to_admin_panel()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertRedirect(route('admin.dashboard'));
    }

    /** @test */
    public function dashboard_route_redirects_user_to_profile_edit()
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertRedirect(route('auth.profile.edit'));
    }
}

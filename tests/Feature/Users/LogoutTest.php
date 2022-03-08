<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LogoutTest extends TestCase
{
   /** @test */
    public function it_should_make_logout()
    {
        $this->withoutExceptionHandling();

        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user)->post(route('app.logout'))
            ->assertStatus(302)
            ->assertRedirect(route('auth.login'));

        $this->assertFalse(Auth::check());
    }
}

<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Carbon\Factory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{

    /** @test */
    public function it_should_guest_to_access_register_routes()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('auth.login'))->assertRedirect(route('home'));
        $this->actingAs($user)->get(route('auth.register'))->assertRedirect(route('home'));
    }

    /** @test */
    public function it_should_saved_in_database()
    {
        $user = User::factory()->make();
        $this->post(route('auth.register', $user->toArray()))
            ->assertRedirect(route('auth.login'));

        $createdUser = User::first();
        $this->assertDatabaseHas('users', [
            'id' => $createdUser->id,
            'name' => $createdUser->name,
            'email' => $createdUser->email,
        ]);
    }

    /** @test */
    public function it_should_email_is_unique()
    {
        $user = User::factory()->make();
        $user->email = 'ph.lima014@gmail.com';

        $this->post(route('auth.register', $user->toArray()));
        $this->post(route('auth.register', $user->toArray()))->assertSessionHasErrors(['email' => trans('validation.unique', ['attribute' => 'email'])]);
    }
}

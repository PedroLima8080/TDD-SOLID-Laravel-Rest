<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Carbon\Factory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Builders\UserBuilder;
use Tests\TestCase;

class RegisterTest extends TestCase
{

    /** @test */
    public function it_should_guest_to_access_register_routes()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('auth.login'))->assertRedirect(route('app.home'));
        $this->actingAs($user)->get(route('auth.register'))->assertRedirect(route('app.home'));
    }

    /** @test */
    public function it_should_saved_in_database()
    {
        $user = (new UserBuilder)->make();
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
        $user = (new UserBuilder)->make();
        $user->email = 'ph.lima014@gmail.com';

        $this->post(route('auth.register', $user->toArray()));
        $this->post(route('auth.register', $user->toArray()))->assertSessionHasErrors(['email' => trans('validation.unique', ['attribute' => 'email'])]);
    }

    /** @test */
    public function it_should_return_error_for_required_fields_when_register()
    {
        $user = (new UserBuilder)->make();
        $user->name = null;
        $user->email = null;
        $user->password = null;

        $this->post(route('auth.register', $user->toArray()))
            ->assertSessionHasErrors(['name' => trans('validation.required', ['attribute' => 'name'])])
            ->assertSessionHasErrors(['email' => trans('validation.required', ['attribute' => 'email'])])
            ->assertSessionHasErrors(['password' => trans('validation.required', ['attribute' => 'password'])]);
    }
}

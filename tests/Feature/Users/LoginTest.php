<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Login extends TestCase
{
     /** @test */
     public function it_should_guest_to_access_login_routes()
     {
         /** @var User $user */
         $user = User::factory()->create();
 
         $this->actingAs($user)->get(route('auth.login'))->assertRedirect(route('home'));
         $this->actingAs($user)->get(route('auth.register'))->assertRedirect(route('home'));
     }

     /** @test */
     public function it_should_make_login()
     {
         $user = User::factory()->make();
 
         $this->post(route('auth.register', $user->toArray())); //registra
         
         $this->post(route('auth.login'), ['email' => $user->email, 'password' => $user->password])
             ->assertRedirect(route('home'));
     }
 
     /** @test */
     public function it_should_return_error_when_login_failed()
     {
         $user = User::factory()->make();
         $this->post(route('auth.register', $user->toArray())); //registra
 
         $this->post(route('auth.login'), ['email' => $user->email, 'password' => '123'])
             ->assertSessionHasErrors(['message']);
     }
}

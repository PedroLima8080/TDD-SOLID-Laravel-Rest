<?php

namespace Tests\Builders;

use App\Models\User;

class UserBuilder{
    public function make(): User{
        $user = User::factory()->make();
        $user->password_confirmation = $user->password;

        return $user;
    }

    public function create(): User{
        $user = User::factory()->create();

        return $user;
    }
}
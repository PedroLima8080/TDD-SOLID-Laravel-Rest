<?php

namespace Tests\Builders;

use App\Models\User;

class UserBuilder{
    public function make(){
        $user = User::factory()->make();
        $user->password_confirmation = $user->password;

        return $user;
    }
}
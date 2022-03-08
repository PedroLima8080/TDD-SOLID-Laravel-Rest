<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RemoveCategoryTest extends TestCase
{
    /** @test */
    public function it_should_be_authenticated_to_remove_category()
    {
        $category = Category::factory()->create();
        $this->delete(route('app.category.destroy', ['id' => $category->id]))
            ->assertStatus(302)
            ->assertRedirect(route('auth.login'));
    }

    /** @test */
    public function it_should_be_remove()
    {
        $category = Category::factory()->create();

        /** @var User $user */
        $user = User::factory()->make();
        $this->actingAs($user)->delete(route('app.category.destroy', ['id' => $category->id]))
            ->assertStatus(302)
            ->assertRedirect(route('app.category.index'));
    }
}

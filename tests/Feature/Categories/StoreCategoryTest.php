<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Builders\ProductBuilder;
use Tests\Builders\UserBuilder;
use Tests\TestCase;

class StoreCategoryTest extends TestCase
{
    /** @test */
    public function it_should_authenticated_to_register_category()
    {
        $category = Category::factory()->make();
        $this->post(route('app.category.store'), $category->toArray())
            ->assertStatus(302)
            ->assertRedirect(route('auth.login'));
    }

    /** @test */
    public function it_return_errors_for_required_inputs()
    {
        $category = Category::factory()->make();
        $category->title = null;

        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('app.category.store'), $category->toArray())
            ->assertSessionHasErrors(['title' => trans('validation.required', ['attribute' => 'title'])]);
    }

    /** @test */
    public function it_name_is_already_in_use()
    {
        Category::factory()->create(['title' => 'Test']);
        $category = Category::factory()->make(['title' => 'Test']);

        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('app.category.store'), $category->toArray())
            ->assertSessionHasErrors(['title' => trans('validation.unique', ['attribute' => 'title'])]);
    }

    /** @test */
    public function it_should_stored_in_database()
    {
        Carbon::setTestNow(now());
        $category = Category::factory()->make();

        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('app.category.store'), $category->toArray())
            ->assertRedirect(route('app.category.index'));

        $this->assertDatabaseHas('categories', [
            'title' => $category->title,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

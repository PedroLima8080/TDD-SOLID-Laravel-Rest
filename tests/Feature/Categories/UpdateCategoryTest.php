<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateCategoryTest extends TestCase
{
    /** @test */
    public function it_should_be_authenticated_to_update_UpdateCategory()
    {
        $category = Category::factory()->create();

        $this->put(route('app.category.update', ['id' => $category->id], $category->toArray()))
            ->assertStatus(302)
            ->assertRedirect(route('auth.login'));
    }

    /** @test */
    public function it_return_errors_for_required_inputs()
    {
        $category = Category::factory()->create();
        $category->title = null;

        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)->put(route('app.category.update', ['id' => $category->id]), $category->toArray())
            ->assertStatus(302)
            ->assertSessionHasErrors(['title' => trans('validation.required', ['attribute' => 'title'])]);
    }

    /** @test */
    public function it_title_is_already_in_use()
    {
        $category = Category::factory()->create();
        $otherCategory = Category::factory()->create();
        $otherCategory->title = $category->title;

        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)->put(route('app.category.update', ['id' => $otherCategory->id]), $otherCategory->toArray())
            ->assertStatus(302)
            ->assertSessionHasErrors(['title' => trans('validation.unique', ['attribute' => 'title'])]);
    }

    /** @test */
    public function it_category_is_updated()
    {

        $this->withoutExceptionHandling();

        $category = Category::factory()->create();
        $category->title = 'New Title';

        Carbon::setTestNow(now());
        
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user)->put(route('app.category.update', ['id' => $category->id]), $category->toArray())
            ->assertStatus(302)
            ->assertRedirect(route('app.category.index'));


        $this->assertDatabaseHas('categories', [
            'title' => $category->title,
            'updated_at' => now()
        ]);
        
    }
}

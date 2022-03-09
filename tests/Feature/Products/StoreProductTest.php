<?php

namespace Tests\Products\Feature;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Builders\UserBuilder;
use Tests\TestCase;
use App\Models\User;
use Carbon\Carbon;
use Tests\Builders\ProductBuilder;

class StoreProductTest extends TestCase
{
    /** @test */
    public function it_should_be_authenticated_to_store_product()
    {
        $this->post(route('app.product.store'))
            ->assertStatus(302)
            ->assertRedirect(route('auth.login'));
    }

    /** @test */
    public function it_should_return_errors_for_required_inputs()
    {
        $user = (new UserBuilder)->create();
        $this->actingAs($user)->post(route('app.product.store'), (new Collection)->toArray())
            ->assertStatus(302)
            ->assertSessionHasErrors(['title' => trans('validation.required', ['attribute' => 'title'])])
            ->assertSessionHasErrors(['price' => trans('validation.required', ['attribute' => 'price'])]);
    }

    /** @test */
    public function it_price_should_be_a_positive()
    {
        $user = (new UserBuilder)->create();
        $product = (new ProductBuilder)->setPrice(-1)->make();

        $this->actingAs($user)->post(route('app.product.store'), $product->toArray())
            ->assertStatus(302)
            ->assertSessionHasErrors(['price' => trans('validation.min.numeric', ['attribute' => 'price', 'min' => 0])]);
    }

    /** @test */
    public function it_price_should_be_a_integer()
    {
        $user = (new UserBuilder)->create();
        $product = (new ProductBuilder)->setPrice(1.5)->make();

        $this->actingAs($user)->post(route('app.product.store'), $product->toArray())
            ->assertStatus(302)
            ->assertSessionHasErrors(['price' => trans('validation.integer', ['attribute' => 'price'])]);
    }

    /** @test */
    public function it_product_is_stored_in_database()
    {
        Carbon::setTestNow(now());

        $user = (new UserBuilder)->create();
        $product = (new ProductBuilder)->make();

        $this->actingAs($user)->post(route('app.product.store'), $product->toArray())
            ->assertStatus(302)
            ->assertRedirect(route('app.product.index'));

        $this->assertDatabaseHas('products', [
            'title' => $product->title,
            'description' => $product->description,
            'price' => $product->price,
            'category_id' => $product->category_id,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /** @test */
    public function it_title_is_unique()
    {
        $user = (new UserBuilder)->create();
        $product = (new ProductBuilder)->create();
        $newProduct = (new ProductBuilder)->setTitle($product->title)->make();

        $this->actingAs($user)->post(route('app.product.store'), $newProduct->toArray())
            ->assertStatus(302)
            ->assertSessionHasErrors(['title' => trans('validation.unique', ['attribute' => 'title'])]);
    }

    /** @test */
    public function it_category_of_product_exist()
    {
        $user = (new UserBuilder)->create();
        $product = (new ProductBuilder)->make();
        $product->category_id = 1e100;

        $this->actingAs($user)->post(route('app.product.store'), $product->toArray())
            ->assertStatus(302)
            ->assertSessionHasErrors(['category_id' => trans('validation.exists', ['attribute' => 'category id'])]);
    }
}

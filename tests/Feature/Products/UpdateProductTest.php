<?php

namespace Tests\Feature\Products;

use Carbon\Carbon;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Builders\ProductBuilder;
use Tests\Builders\UserBuilder;
use Tests\TestCase;

class UpdateProductTest extends TestCase
{
    /** @test */
    public function it_shoulb_be_authenticated_to_updated_product()
    {
        $randomProductId = random_int(1, 1000);

        $this->put(route('app.product.update', $randomProductId), (new Collection)->toArray())
            ->assertStatus(302)
            ->assertRedirect(route('auth.login'));
    }

    /** @test */
    public function it_should_return_error_for_required_fields()
    {
        $user = (new UserBuilder)->create();
        $product = (new ProductBuilder)->create();
        $product['title'] = null;
        $product['price'] = null;
        $product['category_id'] = null;
        
        $this->actingAs($user)->put(route('app.product.update', $product->id), $product->toArray())
            ->assertStatus(302)
            ->assertSessionHasErrors(['title' => trans('validation.required', ['attribute' => 'title'])])
            ->assertSessionHasErrors(['price' => trans('validation.required', ['attribute' => 'price'])])
            ->assertSessionHasErrors(['category_id' => trans('validation.required', ['attribute' => 'category id'])]);
    }

    /** @test */
    public function it_price_should_be_a_positive()
    {
        $user = (new UserBuilder)->create();
        $product = (new ProductBuilder)->create();
        $product['price'] = -1;
        
        $this->actingAs($user)->put(route('app.product.update', $product->id), $product->toArray())
            ->assertStatus(302)
            ->assertSessionHasErrors(['price' => trans('validation.min.numeric', ['attribute' => 'price', 'min' => 0])]);
    }

    /** @test */
    public function it_price_should_be_a_integer()
    {
        $user = (new UserBuilder)->create();
        $product = (new ProductBuilder)->create();
        $product['price'] = 1.1;
        
        $this->actingAs($user)->put(route('app.product.update', $product->id), $product->toArray())
            ->assertStatus(302)
            ->assertSessionHasErrors(['price' => trans('validation.integer', ['attribute' => 'price'])]);
    }

    /** @test */
    public function it_product_is_updated_in_database()
    {
        Carbon::setTestNow(now());

        $user = (new UserBuilder)->create();
        $product = (new ProductBuilder)->create();
        $product['title'] = 'Here is a new title';
        $product['description'] = 'Here is a new description';
        $product['price'] =  1500;
        
        $this->actingAs($user)->put(route('app.product.update', $product->id), $product->toArray())
            ->assertStatus(302)
            ->assertRedirect(route('app.product.index'));

        $this->assertDatabaseHas('products', [
            'title' => 'Here is a new title',
            'description' => 'Here is a new description',
            'price' => 1500,
            'updated_at' => now()
        ]);
    }

    /** @test */
    public function it_title_is_unique()
    {
        $user = (new UserBuilder)->create();
        $product = (new ProductBuilder)->create();
        $otherProduct = (new ProductBuilder)->create();

        $otherProduct['title'] = $product['title'];
        $this->actingAs($user)->put(route('app.product.update', $otherProduct->id), $otherProduct->toArray())
            ->assertStatus(302)
            ->assertSessionHasErrors(['title' => trans('validation.unique', ['attribute' => 'title'])]);
    }

    /** @test */
    public function it_category_of_product_exist()
    {
        $user = (new UserBuilder)->create();
        $product = (new ProductBuilder)->create();

        $product['category_id'] = 5e99;

        $this->actingAs($user)->put(route('app.product.update', $product->id), $product->toArray())
            ->assertStatus(302)
            ->assertSessionHasErrors(['category_id' => trans('validation.exists', ['attribute' => 'category id'])]);
    }
}

<?php

namespace Tests\Feature\Products;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Builders\ProductBuilder;
use Tests\Builders\UserBuilder;
use Tests\TestCase;

class RemoveProductTest extends TestCase
{
    /** @test */
    public function it_should_be_authenticated_to_remove_product()
    {
        $this->delete(route('app.product.destroy', random_int(0, 1000)))
            ->assertStatus(302)
            ->assertRedirect(route('auth.login'));
    }

    /** @test */
    public function it_product_is_removed()
    {
        $user = (new UserBuilder)->create();
        $product = (new ProductBuilder)->create();

        $this->actingAs($user)->delete(route('app.product.destroy', $product->id))
            ->assertStatus(302)
            ->assertRedirect(route('app.product.index'));

        $this->assertDatabaseMissing('products', [
            'id' => $product->id
        ]);
    }
}

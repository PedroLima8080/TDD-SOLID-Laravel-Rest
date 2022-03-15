<?php

namespace Tests\Feature\Products;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Builders\ProductBuilder;
use Tests\Builders\UserBuilder;
use Tests\TestCase;

class ChangeQuantityTest extends TestCase
{
    /** @test */
    public function it_should_be_authenticated_to_change_inventory_quantity(){
        $product = (new ProductBuilder)->create();

        $this->post(route('app.product.change_quantity', ['action' => 'any action', 'product' => $product->id]))
            ->assertStatus(302)
            ->assertRedirect(route('auth.login'));
    }

    /** @test */
    public function it_should_increase_inventory_quantity()
    {
        $user = (new UserBuilder)->create();
        $product = (new ProductBuilder)->setQuantity(5)->create();
        $increaseCount = 2;

        $this->actingAs($user)->post(route('app.product.change_quantity', ['action' => 'increase', 'product' => $product->id]), ['quantity' => $increaseCount])
            ->assertStatus(302)
            ->assertRedirect(route('app.product.index'));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'quantity' => $product->quantity + $increaseCount
        ]);
    }

    /** @test */
    public function it_should_decrease_inventory_quantity()
    {
        $user = (new UserBuilder)->create();
        $product = (new ProductBuilder)->setQuantity(5)->create();
        $increaseCount = 2;

        $this->actingAs($user)->post(route('app.product.change_quantity', ['action' => 'decrease', 'product' => $product->id]), ['quantity' => $increaseCount])
            ->assertStatus(302)
            ->assertRedirect(route('app.product.index'));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'quantity' => $product->quantity - $increaseCount
        ]);
    }
}

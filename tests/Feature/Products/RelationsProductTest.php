<?php

namespace Tests\Products\Feature;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Builders\ProductBuilder;
use Tests\TestCase;

class RelationsProductTest extends TestCase
{
    /** @test */
    public function it_a_product_belongs_to_category()
    {
        $category = Category::factory()->create();
        $product = (new ProductBuilder)->setCategoryId($category->id)->create();

        $this->assertInstanceOf(Category::class, $product->category);
        $this->assertEquals($product->category->id, $category->id);
    }
}

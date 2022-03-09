<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Builders\ProductBuilder;
use Tests\TestCase;

class RelationsCategoryTest extends TestCase
{
    /** @test */
        public function it_a_category_has_many_products()
        {
            $category = Category::factory()->create();
            (new ProductBuilder)->setCategoryId($category->id)->create();
    
            $this->assertEquals(Product::class, $category->products->getQueueableClass());
            $this->assertEquals(1, count($category->products));
        }
}


<?php

namespace Tests\Builders;

use App\Models\Product;

class ProductBuilder{
    protected $fields = [];

    public function make(){
        $product = Product::factory()->make($this->fields);

        return $product;
    }

    public function create(){
        $product = Product::factory()->create($this->fields);

        return $product;
    }

    public function setPrice($price){
        $this->fields['price'] = $price;
        return $this;
    }

    public function setTitle($title){
        $this->fields['title'] = $title;
        return $this;
    }
}
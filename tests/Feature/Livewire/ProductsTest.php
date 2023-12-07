<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Livewire\Products;

class ProductsTest extends TestCase
{
   public function test_component_exists_on_the_page()
   {
       $this->get('/products')
           ->assertSeeLivewire(Products::class);
   }
}

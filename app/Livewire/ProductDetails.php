<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductDetails extends Component
{
    public $product;
    public $current_price;
    public $currentColor;

    public function mount($id)
    {
      $this->product = Product::find($id);
      $this->current_price = $this->product->price;
      $this->currentColor = 'black';
    }
    
    public function render()
    {
      return view('livewire.products.product-details', [
         'product' => $this->product,
      ]);
    }
    
    public function priceWithVariant($price_difference)
    {
       $this->current_price = $this->product->price + $price_difference;
       $this->currentColor = ['red', 'blue', 'green'][array_rand(['red', 'blue', 'green'])];
    }
}

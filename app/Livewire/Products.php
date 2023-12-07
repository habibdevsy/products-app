<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class Products extends Component
{
    public function render()
    {
        return view('livewire.products.products', [
            'products' => Product::all(),
         ]);
    }    
}

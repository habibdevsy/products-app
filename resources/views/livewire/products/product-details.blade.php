

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h2>{{ $product->name }}</h2>
            <p>{{ $product->description }}</p>
            <p style="color: {{ $currentColor }}; font-size:22px;">Price: <span id="product-price">{{ $current_price }}</span></p>

            <p>Stock Quantity: {{ $product->stock_quantity }}</p>
        </div>
        <div class="col-md-6">
            <h3>Variants</h3>
            @foreach($product->variants as $variant)
               <div class="card mb-3">
                 <div class="card-body">
                     <h5 class="card-title">{{ $variant->name }}</h5>
                     <p class="card-text">{{ $variant->price_difference }}</p>
                     <button class="btn btn-primary" wire:click="priceWithVariant({{ $variant->price_difference }})" >Choose Variant</button>
                 </div>
               </div>
            @endforeach
        </div>
    </div>
 </div>
 
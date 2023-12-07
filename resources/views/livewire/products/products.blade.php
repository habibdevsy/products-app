<div class="container">
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4">
              <div class="card">
                  <div class="card-body">
                      <h5 class="card-title">
                        <a href="{{ route('product.details', $product->id) }}" wire:navigate>{{ $product->name }}</a>
                    </h5>
                      <p class="card-text">{{ $product->description }}</p>
                  </div>
              </div>
            </div>
        @endforeach
    </div>
</div>
  
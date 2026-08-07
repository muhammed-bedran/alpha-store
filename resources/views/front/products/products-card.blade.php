

@php
$locale = app()->getLocale();

$name = $product->translatedName($locale) ?: $product->name;
@endphp
<div class="col-xl-3 col-lg-4 col-md-4 col-12">
    <div class="single-product">
        <div class="product-img">
            <a href="product-details.html">
                <img class="default-img" src="{{ asset('image/no-photo.png') }}" alt="#">
                <img class="hover-img" src="{{ asset('image/no-photo.png') }}" alt="#">
            </a>
            <div class="button-head">
                <div class="product-action">
                    <a data-toggle="modal" data-target="#exampleModal" title="Quick View" href="#"><i
                            class=" ti-eye"></i><span>Quick Shop</span></a>
                    <a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Add
                            to
                            Wishlist</span></a>
                    <a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to
                            Compare</span></a>
                </div>
                <div class="product-action-2">
                    <form action="{{ route('cart.items.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn">Add to cart</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="product-content">
           <h3> <a href="product-details.html">{{ $name }}</h3>
            @if ($product->store?->name)
                <h3> <a href="product-details.html">{{ $product->store->name }}</h3>
            @endif
            @if ($product->category?->name)
                <h3> <a href="product-details.html">{{ $product->category->name }}</h3>
            @endif
            <div class="product-price">
                <span>${{ $product->price }}</span>
            </div>
        </div>
    </div>
</div>
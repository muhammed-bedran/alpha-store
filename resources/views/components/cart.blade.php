<div class="sinlge-bar shopping">
    <a href="{{ route('cart.index') }}" class="single-icon">
        <i class="ti-bag"></i>
        <span class="total-count">{{  $count }}</span>
    </a>
    <!-- Shopping Item -->
    <div class="shopping-item">
        <div class="dropdown-cart-header">
            <span>{{ $count }} Items</span>
            <a href="{{ route('cart.index') }}">View Cart</a>
        </div>
        <ul class="shopping-list">
            @foreach ($items as $item)
                @php
                    $product = $item->product;
                    $name = $product?->translatedName() ?: $product?->name;
                @endphp
                <li>
                    <form action="{{ route('cart.items.destroy',$item) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="remove"><i class="ti-close"></i></button>
                    </form>
                </li>
                <h4>{{ $name }}</h4>
                <span class="price">${{ $item->price }}</span>
                <p class="quantity">
                  ({{ $item->quantity }})
                    <span class="amount"> {{ $item->lineTotal() }}</span>
                </p>
            @endforeach


        </ul>
        <div class="bottom">
            <div class="total">
                <span>Total</span>
                <span class="total-amount">{{ $subtotal }}</span>
            </div>
            <a href="{{ route('checkout.create') }}" class="btn animate"> Checkout</a>
        </div>
    </div>
    <!--/ End Shopping Item -->
</div>
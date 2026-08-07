@extends('layouts.website.front')

@section('content')

     <section class="container shop chectout section">
        <div class="contaciner py-5">
            <div class="row">
                <div class="col-12">
                    <h2 class="section-title">Checkout</h2>
                </div>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="row">
            <div class="col-lg-8 col-12">
                <form action="{{ route('checkout.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">customer name</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Name" value="{{ old('customer_name') }}">
                    </div>
                    <div class="form-group">
                        <label for="name">phone </label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Name" value="{{ old('phone') }}">
                    </div>
                    <div class="form-group">
                        <label for="name">address </label>
                        <textarea name="address" class="form-control"> {{ old('address') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="name">note </label>
                        <textarea name="note" class="form-control"> {{ old('note') }}</textarea>
                    </div>
                    <div class="alert alert-info">
                        <div>payment method : cash on delivery</div>
                    </div>
                    <button type="submit" class="btn btn-primary">place order</button>
                </form>
            </div>
            <div class="col">
                <div class="order-details">

                </div>
            </div>
        </div>



     </section>

@endsection
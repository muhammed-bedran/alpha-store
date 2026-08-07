@extends('layouts.website.front')

@section('content')

    <section class="container shop chectout section">

        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Checkout Success</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Thanks for your order</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <a href="{{route('home')}}" class="btn">Continue Shopping</a>
                </div>
            </div>
        </div>


    </section>

@endsection
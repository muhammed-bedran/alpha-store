@extends('layouts.dashboard.user')

@section('title', 'Dashboard')

@section('content')

    <x-flash-message />
  <strong>Order Number: {{ $order->order_number }}</strong>
  <a href="{{ route('user.orders.index') }}" class="btn btn-primary my-3">Back to Orders</a>
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Customer Info</div>
                <div class="card-body">
                    <p>customer name: {{ $order->customer_name }}</p>
                    <p>phone: {{ $order->phone }}</p>

                    <p>order date: {{ $order->created_at }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Store Order Items</div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>#</th>
                            <th>product</th>
                            <th>price</th>
                            <th>quantity</th>
                            <th>Total</th>
                        </tr>
                        <tr>
                            @foreach ($storeItems as $item) 
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->lineTotal() }}</td>
                            @endforeach
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection






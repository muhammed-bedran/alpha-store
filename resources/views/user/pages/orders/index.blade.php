@extends('layouts.dashboard.user')

@section('title', 'Dashboard')

@section('content')
    <x-flash-message />

        @if ($orders->isEmpty())
            <p class="text-muted">
                You have no orders
            </p>
        @else
                    <table class="table">
                        <tr>
                            <th>#</th>
                            <th>order number</th>
                            <th>customer number</th>
                            <th>phone</th>
                            <th>store item total</th>
                            <th>orders</th>
                        </tr>

                    @foreach ($orders as $order)
                                    @php
                        $storeTotal = $order->items->sum(fn($item) => $item->lineTotal());
                                    @endphp
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->customer_name }}</td>
                                    <td>{{ $order->phone }}</td>
                                    <td>{{     $storeTotal}}</td>
                                    <td><a href="{{ route('user.orders.show', $order->id) }}" class="btn btn-primary">View</a></td>
                                </tr>



                    @endforeach

            </table>


        @endif




@endsection
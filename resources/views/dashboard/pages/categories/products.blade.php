@extends('layouts.dashboard')

@section('title', 'Category Products')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.categories.index') }}">Categories</a></li>
    <li class="breadcrumb-item active">{{ $category->name }} Products</li>
@endsection
@section('content')
    <x-flash-message />

    <a href="{{ route('dashboard.categories.index') }}" class="btn btn-secondary">Back to Categories</a>

    <h3 class="mt-3 mb-3">{{ $category->name }} - Products ({{ $products->total() }})</h3>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Store</th>
                <th>Status</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->store->name ?? 'N/A' }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->description }}</td>
                    <td>
                        <a class="btn-primary" href="{{ route('dashboard.products.edit', $item->id) }}">
                            Edit
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No products in this category.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $products->links() }}
@endsection

@push('styles')
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .btn-primary {
            background-color: #007bff;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 14px;
            text-decoration: none;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 14px;
            text-decoration: none;
            color: white;
        }
    </style>
@endpush

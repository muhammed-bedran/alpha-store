

@extends('layouts.dashboard.user')

@section('title', 'Product List')
@section('breadcrumb')
    <li class="breadcrumb-item">Products</li>
@endsection
@section('content')
     <x-flash-message />

        <a href="{{ route('user.products.create') }}" class="btn btn-primary">Create Products</a>




        <form action="{{ URL::current() }}" method="get" class="row g-3 mt-3 mb-3">
           <div class="col-md-4">
                <input type="text" name="name" class="form-control" placeholder="Search by name" value="{{ request()->query('name') }}">
           </div>
           <div class="col-md-3">
                <select name="status" class="form-control">
                    <option value="">All Statuses</option>
                    <option {{ request()->query('status') == 'active' ? 'selected' : '' }} value="active">Active</option>
                    <option {{ request()->query('status') == 'inactive' ? 'selected' : '' }} value="inactive">Inactive</option>
                </select>
           </div>

            <button type="submit" class="btn btn-primary">Search</button>
            <button type="reset" id="resetBtn" class="btn btn-secondary mx-2">Reset</button>
        </form>





        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Store</th>
                    <th>Users Count</th>
                    <th>Status</th>
                    <th>Description</th>
                    <th colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->category->name ?? 'N/A' }}</td>
                        <td>{{ $item->store->name ?? 'N/A' }}</td>
                        <td>{{ $item->users_count }}</td>

                        <td>{{ $item->status }}</td>
                        <td>{{ $item->description }}</td>
                        <td>
                            <a class="btn-primary" href="{{ route('user.products.edit', $item->id) }}">
                                Edit
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('user.products.destroy', $item->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                <!-- Products will be displayed here -->
            </tbody>
        </table>
        {{  $products->links() }}
@endsection

@push('styles')
    <style>
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            text-decoration: none;
        }

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

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        .btn-primary {
            background-color: #007bff;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 14px;
            text-decoration: none;
            color: white;
        }

        .btn-primary {}
    </style>

@endpush

@push('scripts')
<script>
    document.getElementById('resetBtn').addEventListener('click', function() {
        window.location.href = "{{ route('dashboard.stores.index') }}";
    });
</script>
@endpush
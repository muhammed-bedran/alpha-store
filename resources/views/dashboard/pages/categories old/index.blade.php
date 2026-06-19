

@extends('layouts.dashboard')

@section('title', 'Categories')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('categories.index')}}">Categories</a></li>
@endsection
@section('content')


    <a href="{{ route('categories.create') }}" class="btn btn-primary">Create Categories</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th colspan="2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->description }}</td>
                    <td>
                        <a class="btn-primary" href="{{ route('categories.edit', $item->id) }}">
                            Edit
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('categories.destroy', $item->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach

            <!-- Categories will be displayed here -->
        </tbody>
    </table>
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
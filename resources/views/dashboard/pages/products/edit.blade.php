@extends('layouts.dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.products.index')}}">Products</a></li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard.products.index')}}">Stores</a></li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard.products.edit', $product->id)}}">{{ $product->name }}</a></li>
@endsection
@section('title', 'Edit Product')
@section('content')

    <div class="container-fluid">
        <a href="{{ route('dashboard.products.index')}}" class="btn btn-primary mb-3">Products</a>
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Product</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('dashboard.products.update', $product->id) }}" method="post">
                        @csrf
                        @method('PUT')
                            @include('dashboard.pages.products._form')
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>



            </div>

        </div>

    </div><!-- /.container-fluid -->

@endsection

@push('styles')
    <style>
        .form-control {
            display: block;
            width: 100%;
            /* height: calc(2.25rem + 2px); */
            padding: .375rem .75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            /* background-color: #fff; */
            /* background-clip: padding-box; */
            /* border: 1px solid #ced4da; */
            border-radius: .25rem;
            box-shadow: inset 0 0 0 transparent;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

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

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        .form {
            display: flex;
            flex-direction: column;
        }

        .form-control {
            margin-bottom: 15px;
        }

        .form-control label {
            margin-bottom: 5px;
            font-weight: bold;
        }
    </style>
@endpush
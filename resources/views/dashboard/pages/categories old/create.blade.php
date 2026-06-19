@extends('layouts.dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('categories.index')}}">Categories</a></li>
    <li class="breadcrumb-item"><a href="{{ route('categories.create')}}">Create</a></li>
@endsection
@section('title', 'Create Category')
@section('content')

    @if ($errors->any())
        <ul class="alert alert-danger">
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
        </ul>
    @endif

    <div class="container-fluid" >
        <a href="{{ route('categories.index')}}" class="btn btn-primary mb-3">Categories</a>
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create Category</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('categories.store') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Category Name</label>
                                <input type="text" name="name" class="form-control"  placeholder="Category Name">
                                 {{-- @if ($errors->has('name'))
                                     <p class="text-danger">{{ $errors->first('name') }}</p>
                                 @endif --}}
                                 @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                 @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Description</label>
                                <textarea name="description" class="form-control" id="" cols="30" rows="10"></textarea>
                                @if ($errors->has('description'))
                                    <p class="text-danger">{{ $errors->first('description') }}</p>
                                @endif
                            </div>


                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
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
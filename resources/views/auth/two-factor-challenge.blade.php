<x-guest-layout>
    <style>
        .form-control {
            background-color: #333;
            border: 1px solid #555;
            color: #fff;
        }
        .form-control::placeholder {
            color: #bbb;
        }
            .form-control:focus {
                background-color: #333;
                border-color: #777;
                color: #fff;
                box-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
            }
            .form-control::-webkit-input-placeholder {
                color: #bbb;
            }
            .form-control::-moz-placeholder {
                color: #bbb;
            }
            .form-control::-ms-input-placeholder {
                color: #bbb;
            }
            .form-control::placeholder {
                color: #bbb;
            }
            .form-control:focus {
                background-color: #333;
                border-color: #777;
                color: #fff;
                box-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
            }
            .btn-primary {
                background-color: #007bff;
                border-color: #007bff;
            }
            input{
                width: 100%;
                padding: 12px 20px;
                margin: 8px 0;
                box-sizing: border-box;
            }
            button{
                background-color: #007bff;
                border-color: #007bff;
                color: #fff;
                padding: 10px 20px;
                border-radius: 4px;
                cursor: pointer;
            }
                button:hover {
                    background-color: #0056b3;
                    border-color: #0056b3;
                }
                .alert-danger {
                    background-color: #f8d7da;
                    border-color: #f5c6cb;
                    color: #721c24;
                    padding: 10px 20px;
                    border-radius: 4px;
                }

    </style>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
   <div>
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
    <div class="mb-4 text-sm text-white ">
        Admin Login
    </div>
    <form method="POST" action="{{ route('two-factor.login') }}">
        @csrf
        <div class="col-4">
            <input class="form-control" type="text" name="code" placeholder="Enter your authentication code" 
                autofocus>
        </div>
        <div class="col-4">
            <input class="form-control" type="text" name="recovery_code" placeholder="Enter your recovery code" 
                autofocus>
        </div>
        <div class="col-4 mt-3">
            <button type="submit" class="btn btn-primary" >Login</button>
        </div>

    </form>
</x-guest-layout>
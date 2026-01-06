@extends('layout.master_auth')
@section('title', 'PGN SHARE | Login Page')

@section('content')
    <style>
        .field-icon {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            z-index: 10;
            /* tambahkan atau ubah ini */
            cursor: pointer;
            color: #aaa;
            font-size: 1rem;
        }

        .form-group {
            position: relative;
        }
    </style>

    <div class="login-box">
        <center>
            <img src="{{ asset('template/assets/images/logo-pertamina-gas-negara.png') }}" width="200px" alt="Logo PGN">
            <h4 class="mt-4 mb-4"><strong>LOGIN SESSION</strong></h4>
        </center>
        <form method="post" action="{{ action('LoginController@login') }}">
            {{ csrf_field() }}

            <div class="form-group">
                <input class="form-control" type="text" name="username" placeholder="Username"
                    value="{{ old('username') }}" autofocus>
                @error('username')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group position-relative">
                <input id="password" class="form-control" type="password" name="password" placeholder="Password">
                <i toggle="#password" class="fa fa-eye field-icon toggle-password"></i>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-login btn-block btn-lg">LOGIN</button>

            <div class="text-center mt-4">
                <h4 class="card-title">PGN SHARE</h4>
                <p class="card-subtitle">© 2018 - 2025 PT Perusahaan Gas Negara Tbk<br>All Rights Reserved</p>
            </div>
        </form>
    </div>
@endsection

@section('footer')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.querySelector('.toggle-password');
            const input = document.querySelector('#password');

            toggle.addEventListener('click', function() {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        });
    </script>
@stop

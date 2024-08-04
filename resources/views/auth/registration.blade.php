@extends('layout.app')

@section('title', 'Register')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-sm-8 col-md-6">
            <form class="form mt-5" action="{{ route('register') }}" method="post">
                @csrf
                <h3 class="text-center text-dark">@lang('auth.register')</h3>
                <div class="form-group">
                    <label for="name" class="text-dark">@lang('auth.name'):</label><br>
                    <input type="text" name="name" id="name" class="form-control">
                    @error('name')
                        @include('shared.error-message')
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="email" class="text-dark">@lang('auth.email'):</label><br>
                    <input type="email" name="email" id="email" class="form-control">
                    @error('email')
                        @include('shared.error-message')
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="password" class="text-dark">@lang('auth.password'):</label><br>
                    <input type="password" name="password" id="password" class="form-control">
                    @error('password')
                        @include('shared.error-message')
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="confirm-password" class="text-dark">@lang('auth.confirm_password'):</label><br>
                    <input type="password" name="confirm-password" id="confirm-password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="remember-me" class="text-dark"></label><br>
                    <input type="submit" name="submit" class="btn btn-dark btn-md" value="@lang('shared.submit')">
                </div>
                <div class="text-right mt-2">
                    <a href="{{ route('login') }}" class="text-dark">@lang('auth.login_here')</a>
                </div>
            </form>
        </div>
    </div>
@endsection

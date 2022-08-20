@extends('layouts.app')

@section('content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('phone') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="organization" class="col-md-4 col-form-label text-md-end">{{ __('organization') }}</label>

                            <div class="col-md-6">
                                <input id="organization" type="text" class="form-control @error('organization') is-invalid @enderror" name="organization" value="{{ old('organization') }}" required autocomplete="organization">

                                @error('organization')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}



<div class="box">
    <form class="login-form" method="POST" action="{{ route('register') }}">
        @csrf
        <h1>Register User</h1>

        <input id="name" type="text" placeholder="Enter Full Name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $name ?? old('name') }}" required autofocus>

            @error('name')
                <span class="invalid-feedback" role="alert" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        <input id="email" type="email" placeholder="Enter Email " class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email">

            @error('email')
                <span class="invalid-feedback" role="alert" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <input id="password" type="password" placeholder="Enter Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control" name="password_confirmation" required autocomplete="new-password">

        <input id="phone" type="text" placeholder="Enter Pnone Number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $phone ?? old('phone') }}" required>

            @error('phone')
                <span class="invalid-feedback" role="alert" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        <input id="organization" type="text" placeholder="Enter Organization Name" class="form-control @error('organization') is-invalid @enderror" name="organization" value="{{ $organization ?? old('organization') }}" required>

            @error('organization')
                <span class="invalid-feedback" role="alert" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror


        

        <input id="submit" type="submit" class="btn btn-success m-2 px-4" value="{{ __('Register') }}">
            
        <div class="links">
            @if (Route::has('login'))
            <div class="d-block">
            <span>Already have an account? </span><a class="btn-link text-danger fw-bold" href="{{ route('login') }}">
                Click Here
            </a><span> or</span>
            </div>
            @endif
            @if (Route::has('password.request'))
            <span>If lost your password then</span><a class="btn-link text-danger fw-bold" href="{{ route('password.request') }}">
                Click Here
            </a>
            @endif
        </div>
        </button>
    </form> 
</div>
@endsection

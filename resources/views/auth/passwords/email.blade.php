@extends('layouts.app')

@section('content')
<div class="box">
    <form class="login-form" method="POST" action="{{ route('password.email') }}">
        @csrf
        <h1>Password Reset</h1>
        <input id="email" type="email" placeholder="Enter Email for Varification" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <input type="submit" class="btn btn-success m-2 px-4" value="Reset">
            
        <div class="links">
            @if (Route::has('login'))
            <div class="d-block">
                <span>Already have an account? </span><a class="btn-link text-danger fw-bold" href="{{ route('login') }}">
                    Click Here
                </a><span> or</span>
            </div>
            @endif
            @if (Route::has('register'))
            <span>Do not have an account?</span><a class=" btn-link text-danger fw-bold" href="{{ route('register') }}">Click Here</a>
            @endif
        </div>
        </button>
    </form> 
</div>
@endsection

@extends('layouts.app')

@section('content')
<!-- Main Wrapper -->
<div class="main-wrapper login-body">
    <div class="login-wrapper">
        <div class="container">
            <div class="loginbox">
                <div class="login-right">
                    <div class="login-right-wrap">
                        <img class="img-fluid logo-dark mb-2" src="{{ !blank(setting('site_logo')) ? \Storage::url(setting('site_logo')) : asset('site/assets/images/logo.png') }}" alt="Logo">
                        <h1>Reset Password</h1>
                        
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-group">
                                <label class="form-control-label">Email or Mobile No</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <button class="btn btn-lg btn-block btn-primary" type="submit">Send Password Reset Link</button>
                            
                            @if (Route::has('password.request'))
                                <a class="btn-link" href="{{ route('login') }}">
                                    Already have your credentials?
                                </a>
                            @endif
                        </form>

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Main Wrapper -->
@endsection

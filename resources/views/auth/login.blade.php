@extends('layouts.app')

@section('content')
<!-- Main Wrapper -->
<div class="main-wrapper login-body">
    <div class="login-wrapper">
        <div class="container">
            <div class="loginbox">
                <div class="login-right">
                    <div class="login-right-wrap">
                        <img class="img-fluid logo-dark mb-2" src="{{ !blank(setting('site_logo')) ? \Storage::disk('public')->url(setting('site_logo')) : asset('site/assets/images/logo.png') }}" alt="Logo">
                        <h1>Login</h1>
                        <p class="account-subtitle">Access to our dashboard</p>
                        
                        <form method="POST" action="{{ route('login') }}">
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
                            <div class="form-group">
                                <label class="form-control-label">Password</label>
                                <div class="pass-group">
                                    <input id="password" type="password" class="form-control pass-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    <span class="fas fa-eye-slash toggle-password" id="togglePassword" style="cursor: pointer;"></span>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="remember">Remember me</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-lg btn-block btn-primary" type="submit">Login</button>
                            @if (Route::has('password.request'))
                                <a class="btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Main Wrapper -->
@endsection

@push('scripts')
<script type="text/javascript">
     $(document).ready(function() {
        $("#togglePassword").click(function() {
            var passwordField = $("#password");
            var type = passwordField.attr("type") === "password" ? "text" : "password";
            passwordField.attr("type", type);

            // Toggle eye icon class
            $(this).toggleClass("fa-eye fa-eye-slash");
        });
    });
</script>
@endpush

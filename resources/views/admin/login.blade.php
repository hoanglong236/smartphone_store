<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.partials.head')
</head>

<body class="animsition">
    <div class="page-content--bge5">
        <div class="login-wrap">
            <div class="login-content">
                <div class="login-logo">
                    {{ Config::get('constants.site_name') }}
                </div>
                <div class="login-form">
                    <form action="{{ route(Config::get('constants.ADMIN_LOGIN_AUTH_ROUTE')) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Email Address</label>
                            <input class="au-input au-input--full" type="email" name="email"
                                placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input class="au-input au-input--full" type="password" name="password"
                                placeholder="Password" required>
                        </div>
                        <div class="login-checkbox">
                            <label>
                                <input type="checkbox" name="remember">Remember Me
                            </label>
                            <label>
                                <a href="#">Forgotten Password?</a>
                            </label>
                        </div>
                        <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">sign in</button>
                        @if (session()->has('error_mess'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error_mess') }}
                            </div>
                        @else
                            @if (session()->has('success_mess'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success_mess') }}
                                </div>
                            @endif
                        @endif
                    </form>
                    <div class="register-link">
                        <p>
                            Don't you have account?
                            <a href="{{ route(Config::get('constants.ADMIN_REGISTER_ROUTE'))}}">Sign Up Here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.partials.footer-scripts')
</body>
</html>

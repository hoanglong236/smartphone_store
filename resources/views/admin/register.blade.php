<!DOCTYPE html>
<html lang="en">

<head>

    @include('admin.partials.head')

</head>

<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            
                            <a href="#">
                                Register for New Account
                            </a>
                        </div>
                        <div class="login-form">
                            <form action="{{ route('admin.register_handle') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input class="au-input au-input--full" type="email" name="email" placeholder="Email" required>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="au-input au-input--full" type="password" name="password" placeholder="Password" required>
                                </div>
                                <div class="form-group">
                                    <label>Retype Password</label>
                                    <input class="au-input au-input--full" type="password" name="retype_password" placeholder="Retype your Password" required>
                                </div>
                                <div class="form-group">
                                    <label>Fullname</label>
                                    <input class="au-input au-input--full" type="text" name="fullname" placeholder="Fullname" required>
                                </div>
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input class="au-input au-input--full" type="text" name="phone" placeholder="Phone" required>
                                </div>
                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="form-select" name="select_role">
                                        @foreach ($user_roles as $user_role)
                                            <option value="{{ $user_role }}">{{ $user_role }}</option>
                                        @endforeach
                                    </select>
                                </div><br><br>
                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">Register</button>
                                {{session('error_mess_register')}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials.footer-scripts')

</body>

</html>
<!-- end document-->